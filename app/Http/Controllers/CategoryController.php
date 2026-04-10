<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\action_log;
use App\Models\actions;
use App\Models\Regitem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Response;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        // $this->middleware('permission:cat-list|cat-edit|cat-delete', ['only' => ['index','store']]);
         //$this->middleware('permission:cat-add', ['only' => ['create','store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $category = DB::select('SELECT * FROM categories WHERE ActiveStatus="Active" AND IsDeleted=1 ORDER BY categories.id ASC');
        if($request->ajax()) {
            return view('registry.category',['category' => $category])->renderSections()['content'];
        }
        else{
            return view('registry.category',['category' => $category]);
        }
    }

    public function showCategoryData()
    {
        $category=DB::select('SELECT categories.*,cat.Name AS parent_category FROM categories LEFT JOIN categories AS cat ON categories.categories_id=cat.id WHERE categories.IsDeleted=1 AND categories.id > 0 ORDER BY categories.id DESC');
        if(request()->ajax()) {
            return datatables()->of($category)
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();
        $findid = $request->recordId;
        $curdate = Carbon::today()->toDateString();
        $validator = Validator::make($request->all(), [
            'parent_category' => ['required'],
            'Name' => ['required', 'string', 'max:255',Rule::unique('categories')->ignore($findid)],
            'status' => ['required','string','max:255','min:2'],
        ]);

        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $BasicVal = [
                    'categories_id' => $request->parent_category,
                    'Name' => $request->Name,
                    'description' => $request->description,
                    'ActiveStatus' => $request->status,
                    'IsDeleted' => 1,
                ];

                $DbData = Category::where('id', $findid)->first();

                $CreatedBy = ['CreatedBy' => $user];
                $LastUpdatedBy = ['LastEditedBy' => $user];

                $category = Category::updateOrCreate(['id' => $findid],
                    array_merge($BasicVal, $DbData ? $LastUpdatedBy : $CreatedBy),
                );

                $actions = $findid == null ? "Created" : "Edited";

                DB::table('actions')->insert([
                    'user_id' => $userid,
                    'pageid' => $category->id,
                    'pagename' => "category",
                    'action' => $actions,
                    'status' => $actions,
                    'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                    'reason' => "",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();
                return Response::json(['success' => 1]);
            }
            catch(Exception $e){
                DB::rollBack();
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }
        }
        else{
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function fetchParentCategory(){
        $category_data = DB::select('SELECT categories.id,categories.Name FROM categories WHERE ActiveStatus="Active" AND IsDeleted=1 ORDER BY categories.id ASC');
        $all_category_data = DB::select('SELECT * FROM categories WHERE IsDeleted=1 AND categories.id>0 ORDER BY categories.Name ASC');
        return response()->json(['category_data' => $category_data,'all_category_data' => $all_category_data]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = DB::select('SELECT categories.*,cat.Name AS parent_category FROM categories LEFT JOIN categories AS cat ON categories.categories_id=cat.id WHERE categories.id='.$id);
        
        $activitydata = actions::join('users','actions.user_id','users.id')
        ->where('actions.pagename',"category")
        ->where('pageid',$id)
        ->orderBy('actions.id','DESC')
        ->get(['actions.*','users.FullName','users.username']);

        return response()->json(['cat' => $cat,'activitydata' => $activitydata]);
    }

    public function getbyid($id)
    {
        $getid=Category::findOrFail($id);
        return Response::json($getid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $users=Auth()->user();
        $curdate=Carbon::today()->toDateString();
        $findid=$request->id;
        $cat=Category::find($findid);
        $validator = Validator::make($request->all(), [
            'name'=>"required|min:2|max:255|unique:categories,Name,$findid",
            'status'=>"required|min:2|max:255",
        ]);

        if ($validator->passes()) {
            $old = $cat->only(['Name', 'ActiveStatus']);

            $cat->Name=trim($request->input('name'));
            $cat->ActiveStatus=trim($request->input('status'));
            $cat->LastEditedBy=$user;
            $cat->LastEditedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            //$cat->IsDeleted=1;
            $cat->save();

            log_action('updated', 'Category', $cat->id, $old,  $cat->only(['Name', 'ActiveStatus']));
            return Response::json(['success' => '1']);
        }

        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function delete($id)
    {
        $user = Auth()->user()->username;
        $userid = Auth()->user()->id;
        $users = Auth()->user();

        DB::beginTransaction();
        try{

            $record = Category::findOrFail($id);

            if (Category::where('categories_id', $record->id)->exists() || Regitem::where('CategoryId', $record->id)->exists()) {
                return Response::json(['errors' => 465]);
            }

            $actions = "Delete";
            DB::table('actions')->insert([
                'user_id' => $userid,
                'pageid' => $id,
                'pagename' => "category",
                'action' => $actions,
                'status' => $actions,
                'time' => Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A'),
                'reason' => "",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $record->delete();

            DB::commit();
            return Response::json(['success' => 1]);
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request  $request)
    {
        $id=$request->id;
        $delete=$request->all();
        $deletcat=Category::findorFail($id);
        $deletcat->delete();

        return redirect('category')->with('success','Data Deleted Success fully'); 
    }
}
