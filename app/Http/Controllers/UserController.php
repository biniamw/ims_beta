<?php

namespace App\Http\Controllers;

use Hash;
use Response;
use App\events;
use App\Models\User;
use App\Models\store;
use App\Models\storemrc;
use Illuminate\Http\Request;
use App\Models\mrcassignment;
use App\Models\storeassignment;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        if($userid==1)
        {
            $uid=0;
        }
        else
        {
            $uid=1;
        }
        $recstore=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 and id>1');
        $issuestore=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 and id>1');
        $salesstore=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 and id>1');
        $approverstore=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 and id>1');
        $mrcnum=DB::select('select * from companymrcs where ActiveStatus="Active" and IsDeleted=1');
        //$mrcnum=storemrc::where('status','Active')->get(['id','mrcNumber']);
        $counrtys=DB::select('select Name from country order by Name asc');
        $roles = Role::where('id','>',$uid)->pluck('name','name')->all();
        if($request->ajax()) {
            return view('account.user',['counrtys'=>$counrtys,'recstore'=>$recstore,'salesstore'=>$salesstore,'mrcnum'=>$mrcnum,'approverstore'=>$approverstore,'issuestore'=>$issuestore,'roles'=>$roles])->renderSections()['content'];
        }
        else{
            return view('account.user',['counrtys'=>$counrtys,'recstore'=>$recstore,'salesstore'=>$salesstore,'mrcnum'=>$mrcnum,'approverstore'=>$approverstore,'issuestore'=>$issuestore,'roles'=>$roles]);
        }

    }

    public function showUserData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        if($userid==1)
        {
            $uid=0;
        }
        else
        {
            $uid=1;
        }
        $usr=DB::select('SELECT users.id, users.FullName, users.username, users.email, users.email_verified_at, users.password, users.remember_token, users.phone, users.AlternatePhone, users.Address,(SELECT name from roles WHERE id=model_has_roles.role_id) AS RoleName,users.Nationality, users.Gender, users.Status, users.usertype, users.ChangePass, users.IsPurchaser, users.Common, users.created_at,users.updated_at FROM users INNER JOIN model_has_roles ON users.id=model_has_roles.model_id where users.id>'.$uid.' ORDER BY users.id DESC');
        if(request()->ajax()) {
            return datatables()->of($usr)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $passwordresetlink='';
                $usereditlink='';
                if($user->can('User-Edit'))
                {
                $usereditlink=' <a class="dropdown-item editUserInfo" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" id="dteditbtn" data-original-title="Edit">
                <i class="fa fa-edit"></i><span> Edit</span>
                </a>';
                }
                if($user->can('userpaswword-reset'))
                {
                $passwordresetlink=' <a class="dropdown-item resetPass" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" id="dteditbtn" data-original-title="Edit">
                <i class="fa fa-edit"></i><span> Reset Password</span>
               </a>';
                }
                $btn='<div class="btn-group">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item DocUserInfo" data-id="'.$data->id.'" data-role="'.$data->RoleName.'" data-toggle="modal" id="mediumButton" title="Show Detail Info">
                    <i class="fa fa-info"></i><span> Info</span>
                    </a>
                   '.$usereditlink.'
                   '.$passwordresetlink.'

                    </div>
                 </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getUserNumbers()
    {
        $updn=DB::select('update countable set UserCount=UserCount+1 where id=1');
        $usercnt = DB::table('countable')->latest()->first();
        return response()->json(['usercnt'=>$usercnt->UserCount]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user=User::find(27);
        $user->storesmrc()->attach(11);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $findid=$request->userRecId;
        $salesVal=$request->SalesStore;
        $proformaVal=$request->ProformaStore;
        $mrcVal=$request->MrcNumber;
        $receivingVal=$request->receivingstore;
        $issueVal=$request->issuestore;
        $storebalanceval=$request->storebalacestore;
        $reqstore=$request->reqstore;
        $trsrcstore=$request->trsrcstore;
        $trdesstore=$request->trdesstore;
        $adjstore=$request->adjstore;
        $begstore=$request->begstore;
        $approverVal=$request->ApproverStore;
        $transferrecVal=$request->TransferReceiveStore;
        $salesrepstore=$request->salesrepstore;
        $purchaserepstore=$request->purchaserepstore;
        $inventoryrepstore=$request->inventoryrepstore;
        $financialstorevals=$request->financialstore;
        $FitnessSpaVal=$request->FitnessSpa;
        $mrcFitnessVal=$request->MrcNumberFitness;
        $users=User::find($findid);

        if($findid!=null)
        {
            $validator = Validator::make($request->all(), [
                'FullName' => ['required'],
                'PhoneNumber'=>"nullable|unique:users,phone,$findid",
                'EmailAddress'=>"nullable|unique:users,email,$findid",
                'Gender' => ['required'],
                'role'=>['required'],
            ]);
            if ($validator->passes())
            {
                try
                {
                    $user=User::updateOrCreate(['id' => $request->userRecId],
                    [
                        'FullName' =>trim($request->FullName),
                        'email' => trim($request->EmailAddress),
                        'phone' => trim($request->PhoneNumber),
                        'AlternatePhone' => trim($request->AlternatePhoneNumber),
                        'Address' => trim($request->Address),
                        'Nationality' => trim($request->Nationality),
                        'Gender' => trim($request->Gender),
                        'Status' => trim($request->Status),
                        'usertype' => "",
                        'IsPurchaser' => trim($request->checkboxVali),
                    ]);
                    DB::table('model_has_roles')->where('model_id',$findid)->delete();
                    $users->assignRole($request->input('role'));
                    if($salesVal==null)
                    {
                        $removeSalesStr=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=4');
                    }
                    if($salesVal!=null)
                    {
                        $removeSalesStr=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=4');
                        foreach ($request->SalesStore as $SalesStore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($SalesStore);
                            $str->Type=4;
                            $str->save();
                        }
                    }

                    if($proformaVal==null)
                    {
                        $removeProformaStr=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=5');
                    }
                    if($proformaVal!=null)
                    {
                        $removeProformaStr=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=5');
                        foreach ($request->ProformaStore as $ProformaStore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($ProformaStore);
                            $str->Type=5;
                            $str->save();
                        }
                    }

                    if($mrcVal==null)
                    {
                        $removeMRC=DB::select('DELETE FROM mrcassignments WHERE UserId='.$findid.' AND mrcassignments.Type=1');
                    }
                    if($mrcVal!=null)
                    {
                        $user->storesmrc()->detach();
                        foreach ($request->MrcNumber as $MrcNumber)
                        {
                            $user->storesmrc()->attach($MrcNumber);
                        }
                    }

                    if($receivingVal==null)
                    {
                        $removeReceiving=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=1');
                    }
                    if($receivingVal!=null)
                    {
                        $removeReceiving=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=1');
                        foreach ($request->receivingstore as $receivingstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($receivingstore);
                            $str->Type=1;
                            $str->save();
                        }
                    }

                    if($issueVal==null)
                    {
                        $removeIssue=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=2');
                    }
                    if($issueVal!=null)
                    {
                        $removeIssue=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=2');
                        foreach ($request->issuestore as $issuestore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($issuestore);
                            $str->Type=2;
                            $str->save();
                        }
                    }

                    if($storebalanceval==null)
                    {
                        $removeStoreBalance=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=6');
                    }
                    if($storebalanceval!=null)
                    {
                        $removeStoreBalance=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=6');
                        foreach ($request->storebalacestore as $storebalacestore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($storebalacestore);
                            $str->Type=6;
                            $str->save();
                        }
                    }

                    if($reqstore==null)
                    {
                        $removeReqStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=7');
                    }
                    if($reqstore!=null)
                    {
                        $removeReqStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=7');
                        foreach ($request->reqstore as $reqstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($reqstore);
                            $str->Type=7;
                            $str->save();
                        }
                    }

                    if($trsrcstore==null)
                    {
                        $removetrsrcStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=8');
                    }
                    if($trsrcstore!=null)
                    {
                        $removetrsrcStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=8');
                        foreach ($request->trsrcstore as $trsrcstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($trsrcstore);
                            $str->Type=8;
                            $str->save();
                        }
                    }

                    if($trdesstore==null)
                    {
                        $removetrdestStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=9');
                    }
                    if($trdesstore!=null)
                    {
                        $removetrdestStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=9');
                        foreach ($request->trdesstore as $trdesstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($trdesstore);
                            $str->Type=9;
                            $str->save();
                        }
                    }
                    
                    if($adjstore==null)
                    {
                        $removeadjStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=10');
                    }
                    if($adjstore!=null)
                    {
                        $removeadjStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=10');
                        foreach ($request->adjstore as $adjstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($adjstore);
                            $str->Type=10;
                            $str->save();
                        }
                    }

                    if($begstore==null)
                    {
                        $removebegStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=11');
                    }
                    if($begstore!=null)
                    {
                        $removebegStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=11');
                        foreach ($request->begstore as $begstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($begstore);
                            $str->Type=11;
                            $str->save();
                        }
                    }

                    if($approverVal==null)
                    {
                        $removeApprover=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=3');
                    }
                    if($approverVal!=null)
                    {
                        $removeApprover=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=3');
                        foreach ($request->ApproverStore as $ApproverStore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($ApproverStore);
                            $str->Type=3;
                            $str->save();
                        }
                    }

                    if($salesrepstore==null)
                    {
                        $removeSalesRep=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=12');
                    }
                    if($salesrepstore!=null)
                    {
                        $removeSalesRep=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=12');
                        foreach ($request->salesrepstore as $salesrepstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($salesrepstore);
                            $str->Type=12;
                            $str->save();
                        }
                    }

                    if($purchaserepstore==null)
                    {
                        $removePurRep=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=13');
                    }
                    if($purchaserepstore!=null)
                    {
                        $removePurRep=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=13');
                        foreach ($request->purchaserepstore as $purchaserepstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($purchaserepstore);
                            $str->Type=13;
                            $str->save();
                        }
                    }

                    if($inventoryrepstore==null)
                    {
                        $removeInvRep=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=14');
                    }
                    if($inventoryrepstore!=null)
                    {
                        $removeInvRep=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=14');
                        foreach ($request->inventoryrepstore as $inventoryrepstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($inventoryrepstore);
                            $str->Type=14;
                            $str->save();
                        }
                    }

                    if($transferrecVal==null)
                    {
                        $removetrsrcStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=15');
                    }
                    if($transferrecVal!=null)
                    {
                        $removetrsrcStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=15');
                        foreach ($request->TransferReceiveStore as $transferrecVal)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($transferrecVal);
                            $str->Type=15;
                            $str->save();
                        }
                    }

                    if($financialstorevals==null)
                    {
                        $removetrsrcStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=16');
                    }
                    if($financialstorevals!=null)
                    {
                        $removetrsrcStore=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=16');
                        foreach ($request->financialstore as $financialstorevals)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($financialstorevals);
                            $str->Type=16;
                            $str->save();
                        }
                    }

                    if($FitnessSpaVal==null)
                    {
                        $removefitnesspos=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=17');
                    }
                    if($FitnessSpaVal!=null)
                    {
                        $removefitnesspos=DB::select('DELETE FROM storeassignments WHERE UserId='.$findid.' AND storeassignments.Type=17');
                        foreach ($request->FitnessSpa as $fitnesspos)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($findid);
                            $str->StoreId=trim($fitnesspos);
                            $str->Type=17;
                            $str->save();
                        }
                    }
                    return Response::json(['success' =>'1']);
                }

                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }

        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                'FullName' => ['required'],
                'UserName' => ['required','unique:users,username'],
                'PhoneNumber' => ['nullable','unique:users,phone,NULL'],
                'EmailAddress' => ['nullable','unique:users,email'],
                'Gender' => ['required'],
                'role'=>['required'],
            ]);
            if ($validator->passes())
            {
                try
                {
                    $user=User::updateOrCreate(['id' => $request->userRecId],
                    [
                        'FullName' =>trim($request->FullName),
                        'username' => trim($request->UserName),
                        'email' => trim($request->EmailAddress),
                        'password' =>Hash::make("123456"),
                        'phone' => trim($request->PhoneNumber),
                        'AlternatePhone' => trim($request->AlternatePhoneNumber),
                        'Address' => trim($request->Address),
                        'Nationality' => trim($request->Nationality),
                        'Gender' => trim($request->Gender),
                        'Status' => trim($request->Status),
                        'usertype' => "",
                        'ChangePass' => "0",
                        'IsPurchaser' => trim($request->checkboxVali),
                        'Common' =>  trim($request->commonVal),
                    ]);
                    $user->assignRole($request->input('role'));
                    $comn=$request->commonVal;
                    $userheader = DB::table('users')->where('Common', $comn)->latest()->first();
                    $headerid=$userheader->id;
                    if($salesVal!=null)
                    {
                        foreach ($request->SalesStore as $SalesStore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($SalesStore);
                            $str->Type=4;
                            $str->save();
                        }
                    }
                    if($proformaVal!=null)
                    {
                        foreach ($request->ProformaStore as $ProformaStore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($ProformaStore);
                            $str->Type=5;
                            $str->save();
                        }
                    }
                    if($mrcVal!=null)
                    {
                        $user->storesmrc()->detach();
                        foreach ($request->MrcNumber as $MrcNumber)
                        {
                            $user->storesmrc()->attach($MrcNumber);
                        }
                    }
                    if($receivingVal!=null)
                    {
                        foreach ($request->receivingstore as $receivingstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($receivingstore);
                            $str->Type=1;
                            $str->save();
                        }
                    }
                    if($issueVal!=null)
                    {
                        foreach ($request->issuestore as $issuestore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($issuestore);
                            $str->Type=2;
                            $str->save();
                        }
                    }
                    if($storebalanceval!=null)
                    {
                        foreach ($request->storebalacestore as $storebalacestore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($storebalacestore);
                            $str->Type=6;
                            $str->save();
                        }
                    }
                    if($reqstore!=null)
                    {
                        foreach ($request->reqstore as $reqstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($reqstore);
                            $str->Type=7;
                            $str->save();
                        }
                    }
                    if($trsrcstore!=null)
                    {
                        foreach ($request->trsrcstore as $trsrcstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($trsrcstore);
                            $str->Type=8;
                            $str->save();
                        }
                    }
                    if($transferrecVal!=null)
                    {
                        foreach ($request->TransferReceiveStore as $transferrecVal)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($transferrecVal);
                            $str->Type=15;
                            $str->save();
                        }
                    }
                    if($trdesstore!=null)
                    {
                        foreach ($request->trdesstore as $trdesstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($trdesstore);
                            $str->Type=9;
                            $str->save();
                        }
                    }
                    if($adjstore!=null)
                    {
                        foreach ($request->adjstore as $adjstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($adjstore);
                            $str->Type=10;
                            $str->save();
                        }
                    }
                    if($begstore!=null)
                    {
                        foreach ($request->begstore as $begstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($begstore);
                            $str->Type=11;
                            $str->save();
                        }
                    }
                    if($approverVal!=null)
                    {
                        foreach ($request->ApproverStore as $ApproverStore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($ApproverStore);
                            $str->Type=3;
                            $str->save();
                        }
                    }
                    if($salesrepstore!=null)
                    {
                        foreach ($request->salesrepstore as $salesrepstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($salesrepstore);
                            $str->Type=12;
                            $str->save();
                        }
                    }
                    if($purchaserepstore!=null)
                    {
                        foreach ($request->purchaserepstore as $purchaserepstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($purchaserepstore);
                            $str->Type=13;
                            $str->save();
                        }
                    }
                    if($inventoryrepstore!=null)
                    {
                        foreach ($request->inventoryrepstore as $inventoryrepstore)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($inventoryrepstore);
                            $str->Type=14;
                            $str->save();
                        }
                    }

                    if($financialstorevals!=null)
                    {
                        foreach ($request->financialstore as $financialstorevals)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($financialstorevals);
                            $str->Type=16;
                            $str->save();
                        }
                    }

                    if($FitnessSpaVal!=null)
                    {
                        foreach ($request->FitnessSpa as $fitnessspaval)
                        {
                            $str=new storeassignment;
                            $str->UserId=trim($headerid);
                            $str->StoreId=trim($fitnessspaval);
                            $str->Type=16;
                            $str->save();
                        }
                    }

                    return Response::json(['success' =>'1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        }
      //  return Response::json(['errors' => $validator->errors()]);
    }

    public function getReceivingStore($id)
    {
        $receivingStr=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=1) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=1 ORDER BY Name ASC');
        return response()->json(['receivingStr'=>$receivingStr]);
    }

    public function getIssueStore($id)
    {
        $issueStr=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=2) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=2 ORDER BY Name ASC');
        return response()->json(['issueStr'=>$issueStr]);
    }

    public function getStoreBalance($id)
    {
        $storeBalances=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=6) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=6 ORDER BY Name ASC');
        return response()->json(['storeBalances'=>$storeBalances]);
    }

    public function getReqStore($id)
    {
        $reqstr=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=7) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=7 ORDER BY Name ASC');
        return response()->json(['reqstr'=>$reqstr]);
    }

    public function getTrSrcStore($id)
    {
        $trsrc=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=8) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=8 ORDER BY Name ASC');
        return response()->json(['trsrc'=>$trsrc]);
    }

    public function getTrDesStore($id)
    {
        $trdes=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=9) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=9 ORDER BY Name ASC');
        return response()->json(['trdes'=>$trdes]);
    }

    public function getAdjustmentStore($id)
    {
        $adj=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=10) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=10 ORDER BY Name ASC');
        return response()->json(['adj'=>$adj]);
    }

    public function getBeginningStore($id)
    {
        $beg=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=11) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=11 ORDER BY Name ASC');
        return response()->json(['beg'=>$beg]);
    }

    public function getSalesRepStore($id)
    {
        $salesrp=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=12) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=12 ORDER BY Name ASC');
        return response()->json(['salesrp'=>$salesrp]);
    }

    public function getPurRepStore($id)
    {
        $purrp=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=13) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=13 ORDER BY Name ASC');
        return response()->json(['purrp'=>$purrp]);
    }

    public function getInvRepStore($id)
    {
        $invrp=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=14) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=14 ORDER BY Name ASC');
        return response()->json(['invrp'=>$invrp]);
    }

    public function getFinRepStore($id)
    {
        $finrp=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE stores.type="Shop" AND IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=16) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=16 ORDER BY Name ASC');
        return response()->json(['finrp'=>$finrp]);
    }

    public function getApproverStore($id)
    {
        $approveStr=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=3) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=3 ORDER BY Name ASC');
        return response()->json(['approveStr'=>$approveStr]);
    }

    public function getTransferReceiveStore($id)
    {
        $transferrec=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=15) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=15 ORDER BY Name ASC');
        return response()->json(['transferrec'=>$transferrec]);
    }

    public function getSalesStore($id)
    {
        $salesStr=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND stores.type="Shop" AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=4) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=4 ORDER BY Name ASC');
        return response()->json(['salesStr'=>$salesStr]);
    }

    public function getFitnessPos($id)
    {
        $salesStr=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND stores.type="Shop" AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=17) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=17 ORDER BY Name ASC');
        return response()->json(['salesStr'=>$salesStr]);
    }

    public function getProformaNumber($id)
    {
        $proformaNum=DB::select('SELECT id,Name,"Store" AS TableName FROM stores WHERE IsDeleted=1 AND id NOT IN(SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=5) AND stores.id>1 UNION SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=5 ORDER BY Name ASC');
        return response()->json(['proformaNum'=>$proformaNum]);
    }

    public function getMrcNumber($id)
    {
        $mrcNum=DB::select('SELECT id,MRCNumber,"MRC" AS TableName FROM companymrcs WHERE IsDeleted=1 AND id NOT IN(SELECT mrcassignments.MRCId FROM mrcassignments WHERE mrcassignments.UserId='.$id.' AND mrcassignments.Type=1) UNION SELECT mrcassignments.MRCId,companymrcs.MRCNumber AS MRCNumber,"MRCAss" AS TableName FROM mrcassignments INNER JOIN companymrcs ON mrcassignments.MRCId=companymrcs.id WHERE mrcassignments.UserId='.$id.' AND mrcassignments.Type=1');
        return response()->json(['mrcNum'=>$mrcNum]);
    }

    public function getstoresmrc($id){
        $keys = explode(",", $id);
        $storemrc=DB::table('storemrcs')
        ->join('stores','stores.id','=','storemrcs.store_id')
        ->select('storemrcs.id',DB::raw('CONCAT(stores.Name, " - ", storemrcs.mrcNumber) AS mrcNumber'))
        ->whereIn('store_id' ,$keys)
        ->get();
        return Response::json(['storemrc' => $storemrc]);
    }

    public function getstoresmrcft($id){
        $keys = explode(",", $id);
        $storemrc=DB::table('storemrcs')
        ->join('stores','stores.id','=','storemrcs.store_id')
        ->select('storemrcs.id',DB::raw('CONCAT(stores.Name, " - ", storemrcs.mrcNumber) AS mrcNumber'))
        ->whereIn('store_id' ,$keys)
        ->get();
        return Response::json(['storemrc' => $storemrc]);
    }

    public function getAssignedMrc($storeid,$userid){
        //$mrc=User::FindorFail($id)->storesmrc()->select('storemrcs.id','storemrcs.mrcNumber')->get()->makeHidden('pivot');
        //$mrcdoesnothave= storemrc::doesntHave('users')->where('status','Active')->get(['id','mrcNumber']);
        $newq=DB::select('SELECT storemrc_user.storemrc_id,CONCAT(stores.Name," - ",storemrcs.mrcNumber) AS mrcNumber FROM storemrc_user INNER JOIN storemrcs ON storemrc_user.storemrc_id=storemrcs.id INNER JOIN stores ON storemrcs.store_id=stores.id WHERE storemrc_user.user_id='.$userid.' AND storemrc_user.storemrc_id IN(SELECT id FROM storemrcs WHERE store_id IN('.$storeid.'))');
        return Response::json(['mrc' =>$newq]);
    }

    public function getAssignedMrcFt($storeid,$userid){
        //$mrc=User::FindorFail($id)->storesmrc()->select('storemrcs.id','storemrcs.mrcNumber')->get()->makeHidden('pivot');
        //$mrcdoesnothave= storemrc::doesntHave('users')->where('status','Active')->get(['id','mrcNumber']);
        $newq=DB::select('SELECT storemrc_user.storemrc_id,CONCAT(stores.Name," - ",storemrcs.mrcNumber) AS mrcNumber FROM storemrc_user INNER JOIN storemrcs ON storemrc_user.storemrc_id=storemrcs.id INNER JOIN stores ON storemrcs.store_id=stores.id WHERE storemrc_user.user_id='.$userid.' AND storemrc_user.storemrc_id IN(SELECT id FROM storemrcs WHERE store_id IN('.$storeid.'))');
        return Response::json(['mrc' =>$newq]);
    }

    public function getmrcassignedtousers($id){
        $mrc=User::FindorFail($id)->storesmrc()->select('storemrcs.id','storemrcs.mrcNumber')->get()->makeHidden('pivot');
        $mrcdoesnothave= storemrc::doesntHave('users')->where('status','Active')->get(['id','mrcNumber']);
        return Response::json(['mrc' => $mrc,'mrcdoesnothave'=>$mrcdoesnothave]);
    }

    public function getmrcstores()
    {
        $mrc= storemrc::doesntHave('users')->where('status','Active')->get(['id','mrcNumber']);
        return Response::json(['mrc' => $mrc]);
    }

    public function editUserData($id)
    {
       $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $userdata=DB::select('SELECT users.id,users.FullName,users.username,users.email,users.email_verified_at,users.password,users.remember_token,users.phone,users.AlternatePhone,users.Address,(SELECT name from roles WHERE id=model_has_roles.role_id) AS RoleName,model_has_roles.role_id AS RoleId,users.Nationality, users.Gender, users.Status, users.usertype, users.ChangePass, users.IsPurchaser, users.Common, users.created_at,users.updated_at FROM users INNER JOIN model_has_roles ON users.id=model_has_roles.model_id where users.id='.$id);
        $rec=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=1 AND stores.IsDeleted=1');
        $iss=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=2 AND stores.IsDeleted=1');
        $appr=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=3 AND stores.IsDeleted=1');
        $transferrec=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=15 AND stores.IsDeleted=1');
        $pos=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=4 AND stores.IsDeleted=1');
        $proforma=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=5 AND stores.IsDeleted=1');
        $storebl=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=6 AND stores.IsDeleted=1');
        $req=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=7 AND stores.IsDeleted=1');
        $trsrc=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=8 AND stores.IsDeleted=1');
        $trdest=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=9 AND stores.IsDeleted=1');
        $adj=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=10 AND stores.IsDeleted=1');
        $beg=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=11 AND stores.IsDeleted=1');
        $salesrp=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=12 AND stores.IsDeleted=1');
        $purrp=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=13 AND stores.IsDeleted=1');
        $invrp=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=14 AND stores.IsDeleted=1');
        $finrp=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=16 AND stores.IsDeleted=1');
        $fitness=DB::select('SELECT GROUP_CONCAT(" ",stores.Name) as StoreName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=17 AND stores.IsDeleted=1');
        $mrc=DB::select('SELECT CONCAT(stores.Name," - ",storemrcs.mrcNumber) AS MrcNumber FROM storemrc_user INNER JOIN storemrcs ON storemrc_user.storemrc_id=storemrcs.id INNER JOIN stores ON storemrcs.store_id=stores.id WHERE storemrc_user.storemrc_id IN(SELECT id FROM storemrcs WHERE store_id IN(SELECT StoreId FROM storeassignments WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=4))');
        return response()->json(['userdata'=>$userdata,'rec'=>$rec,'iss'=>$iss,'appr'=>$appr,'transferrec'=>$transferrec,'pos'=>$pos,'proforma'=>$proforma,'storebl'=>$storebl,'req'=>$req,'trsrc'=>$trsrc,'trdest'=>$trdest,'adj'=>$adj,'beg'=>$beg,'mrc'=>$mrc,'invrp'=>$invrp,'purrp'=>$purrp,'salesrp'=>$salesrp,'finrp'=>$finrp,'fitness'=>$fitness]);
    }

    public function showSalesStoreData($id)
    {
        $detailTable=DB::select('SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=4 ORDER BY Name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showProformaStores($id)
    {
        $detailTable=DB::select('SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=5 ORDER BY Name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showUserMrcData($id)
    {
        $usermrc = User::find($id)->storesmrc()->get()->makeHidden('pivot');
        return datatables()->of($usermrc)->addIndexColumn()->toJson();
    }

    public function showReceivingStoreData($id)
    {
        $detailTable=DB::select('SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=1 ORDER BY Name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function showIssueStoreData($id)
    {
        $detailTable=DB::select('SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=2 ORDER BY Name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }
    public function showApproverStoreData($id)
    {
        $detailTable=DB::select('SELECT storeassignments.StoreId,stores.Name AS StoreName,"StoreAss" AS TableName FROM storeassignments INNER JOIN stores ON storeassignments.StoreId=stores.id WHERE storeassignments.UserId='.$id.' AND storeassignments.Type=3 ORDER BY Name ASC');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function ResetUserPassword(Request $request)
    {
        $findid=$request->resetUserId;
        $usr=User::find($findid);
        $usr->password = Hash::make("123456");
        $usr->changePass='0';
        $usr->save();
        return Response::json(['success' => '1']);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
