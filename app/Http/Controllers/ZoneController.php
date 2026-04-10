<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\User;
use App\Models\Region;
use App\Models\Woreda;
use App\Models\Commudity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use DataTables;
use Carbon\Carbon;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::where('id','>',1)->orderBy('created_at', 'DESC')->get();
        if($request->ajax()) {
            return view('registry.zone',['regions'=>$regions])->renderSections()['content'];
        }
        else{
            return view('registry.zone',['regions'=>$regions]);
        }
       
    }
    public function getzones()
    {
        $zones = Zone::with('region')
            ->select('*')
            ->where('id','>',1)
            ->orderBy('created_at', 'desc');
        return datatables()
            ->of($zones)
            ->addIndexColumn()
            ->make(true);
    }
    public function getzoneinfo($id)
    {
        $zone = Woreda::select('*')->where('zone_id', $id);
        return datatables()
            ->of($zone)
            ->addIndexColumn()
            ->make(true);
    }
    public function store(Request $request)
    {
        $id = $request->zoneId;

        $validator = Validator::make($request->all(), [
            'Zone_Name' => ['required', 'string', 'max:255', Rule::unique('zones')->ignore($id)], //zone should be unique ,all unique validation should be handled by validation not by exception ok
            'Rgn_Id' => 'required',
            'status' => 'required|string|max:255',
        ]);
        
       
        if ($validator->passes()) {
            try {
                $commonValues = [
                    'Zone_Name' => $request->Zone_Name,
                    'Rgn_Id' => $request->Rgn_Id,
                    'description' => $request->description,
                    'status' => $request->status,
                ];
                // Values specific to updating
                $updateValues = ['updated_by' => auth()->user()->id];
                // Values specific to creating
                $createValues = ['created_by' => auth()->user()->id];
                $existingRecord = Zone::where('id', $id)->first();
                $zone = Zone::updateOrCreate(['id' => $id], array_merge($commonValues, $existingRecord ? $updateValues : $createValues));
                return response()->json(['success' =>1]);
            } 
            catch (QueryException $e) {
                return response()->json(['errorv2' => 'An error occured.','type' => $e->getMessage()]);
            }
        } 
        elseif ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }  
    }

    public function edit($id)
    {
        $zone = Zone::find($id);
        $woreda = Woreda::where('zone_id', $zone->id)->get();
        return response()->json([
            'status' => 200,
            'zone' => $zone,
            'woreda' => $woreda,
        ]);
    }

    public function show($id)
    {
        $znn = Zone::find($id);
        $cid = $znn->created_by;
        $crdate = Carbon::createFromFormat('Y-m-d H:i:s', $znn->created_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])
            ->format('Y-m-d @ g:i:s A');
        $upgdate = Carbon::createFromFormat('Y-m-d H:i:s', $znn->updated_at)
            ->settings(['timezone' => 'Africa/Addis_Ababa'])
            ->format('Y-m-d @ g:i:s A');
        $r_id = $znn->Rgn_Id;
        $r_n = Region::find($r_id);
        if (empty($r_n)) {
            $r_n = '';
        }
        $cr = User::find($cid);
        if (empty($cr)) {
            $cr = '';
        }
        $uid = $znn->updated_by;
        if (empty($uid)) {
            $ur = '';
        } else {
            $ur = User::find($uid);
        }
        return response()->json([
            'status' => 200,
            'zone' => $znn,
            'cr' => $cr,
            'ur' => $ur,
            'rn' => $r_n,
            'crdate' => $crdate,
            'upgdate' => $upgdate,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function woredacheck(Request $request)
    {
        if ($request->zoneidval == 0) {
            $woreda_name = Woreda::where('Woreda_Name', $request->Woredanam)->first();
            $woreda_wh = Woreda::where('Wh_name', $request->Whnam)->first();
            $woreda_phone = Woreda::where('phone', $request->Phonenam)->first();
            $woreda_email = Woreda::where('email', $request->Emailnam)->first();
            if ($woreda_name) {
                return response()->json([
                    'wordn' => '2',
                ]);
            }
            if ($woreda_wh) {
                return response()->json([
                    'wordn' => '3',
                ]);
            }
            if ($woreda_phone) {
                return response()->json([
                    'wordn' => '4',
                ]);
            }
            if ($woreda_email) {
                return response()->json([
                    'wordn' => '5',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $woreda = Woreda::findOrFail($id);
        if ($woreda) {
            $woreda->delete();
        }
    }

    public function trytodeletezone($id)
    {
        
        $zone = Woreda::where('zone_id', $id)->count();
        
        return response()->json(['zonedetcnt' => $zone]);
    }

    public function deletezone($id)
    {
        try {
            // $id = $request->zonedelId;
            $zone = Zone::findOrFail($id);
            if ($zone) {
                $zone->delete();
                return response()->json(['success' => 'Successfull']);
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            return response()->json(['error' => 'This id available on another table.']);
        }
    }
}
