<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Response;
use DB;

class RoleController extends Controller
{
    //
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {
        $categorypermission = Permission::where('Page','Category')->get();
        $uompermission = Permission::where('Page','UOMS')->get();
        $itempermission = Permission::where('Page','Items')->get();
        $customerpermission = Permission::where('Page','Customer')->get();
        $storerpermission = Permission::where('Page','Store')->get();
        $brandpermission = Permission::where('Page','Brand')->get();
        $salespermission = Permission::where('Page','Sale')->get();
        $recievingpermission = Permission::where('Page','Receiving')->get();
        $requisitiongpermission = Permission::where('Page','Requisition')->get();
        $storetransferpermission = Permission::where('Page','Transfer')->get();
        $approvalpermission = Permission::where('Page','Approver')->get();
        $issuepermission = Permission::where('Page','Issue')->get();
        $adjustmentpermission = Permission::where('Page','Adjustment')->get();
        $beginingpermission = Permission::where('Page','Begining')->get();
        $deadpermission = Permission::where('Page','deadstock')->get();
        $stockbalancepermission = Permission::where('Page','StoreBalance')->get();
        $settlementpermission = Permission::where('Page','Settlement')->get();
        $reportpermission = Permission::where('Page','Report')->get();
        $setingpermission = Permission::where('Page','Setting')->get();
        $accountpermission = Permission::where('Page','User')->get();
        $rolepermission = Permission::where('Page','Role')->get();
        $servicepermission = Permission::where('Page','Service')->get();
        $memberpermission = Permission::where('Page','Membership')->get();
        $employeepermission = Permission::where('Page','Employee')->get();
        $applicationpermission = Permission::where('Page','Application')->get();
        $periodpermission = Permission::where('Page','Period')->get();
        $grouppermission = Permission::where('Page','Group')->get();
        $paymenttermpermission = Permission::where('Page','PaymentTerm')->get();
        $bankpermission = Permission::where('Page','Bank')->get();
        $incomefollowuppermission = Permission::where('Page','Income-Follow-Up')->get();
        $devicepermission = Permission::where('Page','Device')->get();
        $branchpermission = Permission::where('Page','Branch')->get();
        $departmentpermission = Permission::where('Page','Department')->get();
        $salarypermission = Permission::where('Page','Salary')->get();
        $positionpermission = Permission::where('Page','Position')->get();
        $shiftpermission = Permission::where('Page','Shift')->get();
        $trainerpermission = Permission::where('Page','Trainer')->get();
        $leaverequestpermission = Permission::where('Page','Leave-Request')->get();
        $holidaypermission = Permission::where('Page','Holiday')->get();
        $leavetypepermission = Permission::where('Page','Leave-Type')->get();
        $staffpermission = Permission::where('Page','Staff')->get();
        $timetablepermission = Permission::where('Page','Timetable')->get();
        $shiftschpermission = Permission::where('Page','Shift-Schedule')->get();
        $salarytypepermission = Permission::where('Page','Salary-Component')->get();
        $attendancepermission = Permission::where('Page','Attendance')->get();
        $otlevelpermission = Permission::where('Page','Overtime-Level')->get();
        $payrolladdpermission = Permission::where('Page','Payroll-Addition-Deduction')->get();
        $payrollpermission = Permission::where('Page','Payroll')->get();
        $commoditybegpermission = Permission::where('Page','Commodity-Beginning')->get();
        $commoditystockbalancepermission = Permission::where('Page','Commodity-StockBalance')->get();
        $proformapermission = Permission::where('Page','Proforma')->get();
        $bompermission = Permission::where('Page','BOM')->get();
        $prorderpermission = Permission::where('Page','Production-Order')->get();
        $regionpermission = Permission::where('Page','Region')->get();
        $zonepermission = Permission::where('Page','Zone')->get();
        $woredapermission = Permission::where('Page','Woreda')->get();
        $dispatchpermission = Permission::where('Page','Dispatch')->get();
        $directstockin = Permission::where('Page','direct-stockin')->get();
        $directstockout = Permission::where('Page','direct-stockout')->get();
        $directstockbalance = Permission::where('Page','direct-stock-balance')->get();

        if($request->ajax()) {
            return view('account.role',compact('categorypermission','uompermission','itempermission','customerpermission','storerpermission','brandpermission',
                'salespermission','recievingpermission','requisitiongpermission','storetransferpermission','approvalpermission',
                'deadpermission','stockbalancepermission','issuepermission','adjustmentpermission','beginingpermission',
                'settlementpermission','reportpermission','setingpermission','accountpermission','rolepermission','servicepermission',
                'memberpermission','employeepermission','applicationpermission','periodpermission','grouppermission','paymenttermpermission','bankpermission',
                'incomefollowuppermission','devicepermission','branchpermission','departmentpermission','salarypermission','positionpermission','shiftpermission','proformapermission',
                'trainerpermission','staffpermission','leaverequestpermission','holidaypermission','timetablepermission','leavetypepermission','shiftschpermission','salarytypepermission',
                'attendancepermission','otlevelpermission','payrolladdpermission','payrollpermission','commoditybegpermission','commoditystockbalancepermission','bompermission',
                'regionpermission','zonepermission','woredapermission','prorderpermission','dispatchpermission','directstockin','directstockout','directstockbalance'))->renderSections()['content'];
        }
        else{
            return view('account.role',compact('categorypermission','uompermission','itempermission','customerpermission','storerpermission','brandpermission',
                'salespermission','recievingpermission','requisitiongpermission','storetransferpermission','approvalpermission',
                'deadpermission','stockbalancepermission','issuepermission','adjustmentpermission','beginingpermission',
                'settlementpermission','reportpermission','setingpermission','accountpermission','rolepermission','servicepermission',
                'memberpermission','employeepermission','applicationpermission','periodpermission','grouppermission','paymenttermpermission','bankpermission',
                'incomefollowuppermission','devicepermission','branchpermission','departmentpermission','salarypermission','positionpermission','shiftpermission','proformapermission',
                'trainerpermission','staffpermission','leaverequestpermission','holidaypermission','timetablepermission','leavetypepermission','shiftschpermission','salarytypepermission',
                'attendancepermission','otlevelpermission','payrolladdpermission','payrollpermission','commoditybegpermission','commoditystockbalancepermission','bompermission',
                'regionpermission','zonepermission','woredapermission','prorderpermission','dispatchpermission','directstockin','directstockout','directstockbalance'));
        }
    }

    public function getRoleList()
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
        $Userdata=DB::select('SELECT * FROM roles WHERE roles.id>'.$uid.' ORDER BY id DESC');
        if(request()->ajax()) {
            return datatables()->of($Userdata)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $user=Auth()->user();
                $roleeditlink='';
                $roledeletelink='';

                if($user->can('Role-Edit')){
                    $roleeditlink='<a class="dropdown-item editRole" href="javascript:void(0)" data-toggle="modal"  data-id="'.$data->id.'" data-name="'.$data->name.'" data-status="'.$data->status.'" data-original-title="Edit" title="Edit Record">
                        <i class="fa fa-edit"></i><span> Edit</span>
                    </a>';
                }

                if($user->can('Role-Delete')){
                    $roledeletelink=' <a class="dropdown-item deleteUser" data-id="'.$data->id.'" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record">
                    <i class="fa fa-trash"></i><span> Delete</span>
                    </a>';
                }
                $btn='<div class="btn-group">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                    <div class="dropdown-menu">
                        '.$roleeditlink.'
                        '.$roledeletelink.'
                    </div>
                </div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getPermission()
    {
        $getPermission = Permission::get();



        return response()->json(['getPermission'=>$getPermission,

        ]);

    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role' => "required|regex:/^[a-zA-Z]+$/u|max:255|unique:roles,name,$request->roleID",
            'status'=>'required',
            ]);
            if ($validator->passes()) {
                $role = Role::updateOrCreate(['id' =>$request->roleID],[
                    'name' => $request->input('role'),
                    'status'=>$request->input('status'),
                    'description'=>$request->input('description')
                ]);
                $role->syncPermissions($request->input('permission'));
                return Response::json(['success' => '1']);
            }
            if($validator->fails())
            {
                return Response::json(['errors' => $validator->errors()]);
            }
    }

    public function create()
    {
       // $permission = Permission::get();
       // return view('account.role',compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:roles,name,'.$id,
           // 'permissions' => 'required',
            'status'=>'required',

            ]);
            if ($validator->passes()) {
                $role = Role::find($id);
                $role->name = $request->input('role');
                $role->save();
                $role->syncPermissions($request->input('permission'));
                return Response::json(['success' => 'updated role']);
            }

            if($validator->fails())
            {
                return Response::json(['errors' => $validator->errors()]);
            }



    }

    public function getrolepermission($id){
        $role = Role::find($id);
        $permissions = $role->permissions()->get();
        return Response::json(['permissions'=>$permissions,]);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
            //$rolePermissions=DB::select("SELECT role_id,permission_id,roles.name AS RoleName,permissions.name AS PermissionName,permissions.Page FROM `role_has_permissions` INNER JOIN roles ON role_has_permissions.role_id=roles.id INNER JOIN permissions ON role_has_permissions.permission_id=permissions.id WHERE role_has_permissions.role_id=".$id);
            // $rolePermissions=DB::select('SELECT role_id,permission_id,roles.name AS RoleName,permissions.name AS PermissionName ,permissions.Page,"role_has_permissions" AS TableName FROM role_has_permissions INNER JOIN roles ON role_has_permissions.role_id=roles.id INNER JOIN permissions ON role_has_permissions.permission_id=permissions.id WHERE role_has_permissions.role_id='.$id.' UNION SELECT permissions.id,permissions.id,permissions.name,permissions.name,permissions.Page,"permissions" AS TableName FROM permissions WHERE permissions.id NOT IN(SELECT permission_id FROM role_has_permissions where role_has_permissions.role_id='.$id.')');
            
            return Response::json([
                'role'=>$role,
                'rolePermissions'=>$rolePermissions,
            ]);

    }

    public function deleterole($id)
    {
        $rolehaspermission=DB::select('select * from role_has_permissions where role_id='.$id.'');
        if($rolehaspermission==null)
        {
            DB::table("roles")->where('id',$id)->delete();

            return Response::json([

                'success'=>'Role Deleted successfully',

            ]);
        }
        else
        {
            return Response::json(['deleterrors' => 'This Role is Assigned to User']);
        }
    }
}
