<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use DataTables;
use Carbon\Carbon;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::select('*');
        if($request->ajax()){
            return view('registry.region')->renderSections()['content'];
        }
        else{
            return view('registry.region');
        }
    }
    public function getregions()
    {
        $regions = Region::select('*')->where('id','>',1)->orderBy('created_at', 'desc');

        return datatables()
            ->of($regions)
            ->addIndexColumn()
            ->make(true);
    }
    public function store(Request $request, $id = null)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Rgn_Name' => ['required', Rule::unique('regions')->ignore($id)],
                'Rgn_Number' => ['required', Rule::unique('regions')->ignore($id)],
                'status' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages(),
                ]);
            } else {
                $commonValues = [
                    'Rgn_Name' => $request->Rgn_Name,
                    'Rgn_Number' => $request->Rgn_Number,
                    'description' => $request->description,
                    'status' => $request->status,
                ];
                // Values specific to updating
                $updateValues = [
                    'updated_by' => auth()->user()->id,
                ];
                // Values specific to creating
                $createValues = [
                    'created_by' => auth()->user()->id,
                ];
                $existingRecord = Region::where('id', $id)->first();
                $region = Region::updateOrCreate(
                    ['id' => $id], // The unique column to identify the record
                    array_merge($commonValues, $existingRecord ? $updateValues : $createValues),
                );
                $message = 'Successfully.';
                return response()->json([
                    'success' => $message,
                ]);
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                // 1062 is the MySQL error code for unique constraint violation
                return response()->json(['errors' => 'Duplicate entry. Region name or region number already exists.', 'type' => 'dup']);
            }
            return response()->json(['errors' => 'An error occured.', 'type' => 'faild']);
        }
    }
    public function edit($id)
    {
        $region = Region::find($id);
        return response()->json([
            'status' => 200,
            'region' => $region,
        ]);
    }
    public function show($id)
    {
        $region = Region::find($id);
        $crdate = Carbon::createFromFormat('Y-m-d H:i:s', $region->created_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $upgdate = Carbon::createFromFormat('Y-m-d H:i:s', $region->updated_at)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $cid = $region->created_by;
        $cr = User::find($cid);
        if (empty($cr)) {
            $cr = '';
        }
        $uid = $region->updated_by;
        $ur = User::find($uid);
        if (empty($ur)) {
            $ur = '';
        }
        return response()->json([
            'status' => 200,
            'region' => $region,
            'cr' => $cr,
            'ur' => $ur,
            'crdate'=>$crdate,
            'upgdate'=>$upgdate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::find($id);
        if ($region) {
            $region->delete();
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
