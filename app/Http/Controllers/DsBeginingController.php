<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use App\Models\begining;
use App\Models\beginingdetail;
use App\Models\DsBegining;
use App\Models\dsbeginingdetail;
use App\Models\transaction;
use App\Models\Regitem;
use App\Models\uom;
use App\Models\serialandbatchnum;

class DsBeginingController extends Controller
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
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $storeSrc=DB::select('SELECT id as StoreId,stores.Name as StoreName FROM stores WHERE stores.ActiveStatus="Active" AND stores.IsDeleted=1');
        $syncStoreSrc=DB::select('select * from stores where ActiveStatus="Active" and IsDeleted=1 and id>=2 order by Name asc');
        $itemSrc=DB::select('SELECT DISTINCT(ItemId),regitems.Name AS ItemName,regitems.Code AS Code,regitems.SKUNumber AS SKUNumber FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE regitems.ActiveStatus="Active" AND regitems.IsDeleted=1');
        $brand=DB::select('select * from brands where ActiveStatus="Active" and IsDeleted=1');
        $edbrand=DB::select('select * from brands where ActiveStatus="Active" and IsDeleted=1');
        $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fyear.' order by fiscalyear.FiscalYear DESC');

        if($request->ajax()) {
            return view('inventory.dsbegining',['storeSrc'=>$storeSrc,'syncStoreSrc'=>$syncStoreSrc,'itemSrc'=>$itemSrc,'brand'=>$brand,'edbrand'=>$edbrand,'fiscalyears'=>$fiscalyears])->renderSections()['content'];
        }
        else{
            return view('inventory.dsbegining',['storeSrc'=>$storeSrc,'syncStoreSrc'=>$syncStoreSrc,'itemSrc'=>$itemSrc,'brand'=>$brand,'edbrand'=>$edbrand,'fiscalyears'=>$fiscalyears]);
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

    public function showBeginingData()
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $settings = DB::table('settings')->latest()->first();
        $fyear=$settings->FiscalYear;
        $req=DB::select('SELECT dsbeginings.id,dsbeginings.DocumentNumber,dsbeginings.EndingDocumentNo,stores.Name as Store,dsbeginings.FiscalYear,fiscalyear.Monthrange AS FiscalYearRange,dsbeginings.Date,dsbeginings.Username,dsbeginings.Status FROM dsbeginings INNER JOIN stores ON dsbeginings.StoreId=stores.id INNER JOIN fiscalyear ON dsbeginings.FiscalYear=fiscalyear.FiscalYear WHERE dsbeginings.FiscalYear='.$fyear.' ORDER BY dsbeginings.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $infobtn='';
                $editbtn='';
                $startcountbtn='';
                $resumecount='';
                $countnoteln='';
                $begnoteln='';
                $adjustln='';
                if($data->Status=='Ready')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn=' <a class="dropdown-item startCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Start Counting</span>  </a>';
                    $infobtn='';
                    $resumecount='';
                    $countnoteln='';
                    $begnoteln='';
                    $adjustln='';
                }
                else if($data->Status=='Counting')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/dsbg/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Done')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span>  </a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/dsbg/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn=' <a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/dsbg/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Posted')
                {
                    $editbtn='';
                    $startcountbtn='';
                    $infobtn=' <a class="dropdown-item infoDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span>  </a>';
                    $resumecount='';
                    if($user->can('Begining-Adjust'))
                    {
                        $adjustln='  <a class="dropdown-item adjustmentBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Adjust</span></a>';
                    }
                    $begnoteln=' <a class="dropdown-item printBgAttachment" href="javascript:void(0)" data-link="/dsbgp/'.$data->id.'" id="printbgatt" data-attr="" title="Print Begining Attachment"><i class="fa fa-file"></i><span> Print Attachment</span></a>';
                    $countnoteln=' ';
                  
                }
                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        '.$infobtn.'
                        '.$startcountbtn.'
                        '.$resumecount.' 
                        '.$adjustln.'
                        '.$begnoteln.'  
                        '.$countnoteln.'   
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getBgNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $bprefix=$settings->BeginingPrefix;
        $bnumber=$settings->BeginingNumber;
        $numberPadding=sprintf("%06d", $bnumber);
        $bgNumber=$bprefix.$numberPadding;
        $updn=DB::select('update countable set BeginingCount=BeginingCount+1 where id=1');
        $reqCountNum = DB::table('countable')->latest()->first();
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        return response()->json(['bgNumber'=>$bgNumber,'BeginingCount'=>$reqCountNum->BeginingCount,'FiscalYear'=>$fiscalyr]);
    }


    public function editBegining($id)
    {
        $begining = DsBegining::find($id);
        return response()->json(['begining'=>$begining]);
    }

    public function store(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $headerid=$request->beginingId;
        $findid=$request->beginingId;
        $valstore=$request->store;
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $dprefix=$settingsval->DSBeginingPrefix;
        $dnumber=$settingsval->DSBeginingNumber;
        $rnumberPadding=sprintf("%06d", $dnumber);
        $dsdocnumber=$dprefix.$rnumberPadding;

        if($valstore==null){
            return Response::json(['requirederror' =>  "error"]);
        }
        $checkduplicate=DB::select('SELECT COUNT(id) AS CountId FROM dsbeginings WHERE dsbeginings.StoreId='.$valstore.' AND dsbeginings.FiscalYear='.$fiscalyr);
        foreach($checkduplicate as $row)
        {
            $countid=$row->CountId;
        }
        $countids = (float)$countid;

        if($countids>=1)
        {
            return Response::json(['duplicateerror' =>  "error"]);  
        }
        if($findid!=null)
        {
            $validator = Validator::make($request->all(), [
                'store' => ['required'],
            ]);
            if ($validator->passes()) 
            {
                try
                {
                    $begining=DsBegining::updateOrCreate(['id' => $request->beginingId], [
                    'StoreId' => trim($request->store),
                    ]);
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
        }

        if($findid==null)
        {
            $validator = Validator::make($request->all(), [
                $dsdocnumber=>"unique:dsbeginings,DocumentNumber,$findid",
                'store' => ['required'],        
            ]);

            if ($validator->passes())
            {
                try
                {
                    $begining=DsBegining::updateOrCreate(['id' => $request->beginingId], [
                    'DocumentNumber' => $dsdocnumber,
                    'StoreId' => trim($request->store),
                    'FiscalYear' => $fiscalyr,
                    'Username' => $user,
                    'Status' => "Ready",
                    'CalendarType' => "",
                    'Memo' => "-",
                    'Common' =>trim($request->commonVal),
                    'Date'=>Carbon::today()->toDateString(),
                    ]);
                    
                    if( $request->beginingId==null)
                    {
                        $updn=DB::select('update settings set DSBeginingNumber=DSBeginingNumber+1 where id=1');
                    }
                    return Response::json(['success' => '1']);
                }
                catch(Exception $e)
                {
                    return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            $headerid=$request->beginingId;
            $strids=$request->store;
            DB::table('dsbeginingdetails')
            ->where('HeaderId',$headerid)
            ->update(['StoreId'=>$strids]);
        }   
        
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
        if($v2->fails())
        {
            return response()->json([
                'errorv2'  => $v2->errors()->all()
               ]);
        }
    }

    public function startCountingCon(Request $request)
    {
        $findid=$request->countid;
        $strid=$request->storeidi;
        $bg=DsBegining::find($findid);
        $syncToDsBegining=DB::select('INSERT INTO dsbeginingdetails(ItemId,ItemType,HeaderId,StoreId,TransactionType,Date)SELECT id,Type,'.$findid.','.$strid.',"Begining","'.Carbon::now()->toDateString().'" FROM regitems WHERE regitems.ActiveStatus="Active" AND regitems.Type!="Service" AND regitems.IsDeleted=1');
        $bg->Status="Counting";
        $bg->save();
        return Response::json(['success' => '1']);
    }

    public function showBgHeader($id)
    {
        $ids=$id;
        $pricing = DB::table('dsbeginingdetails')
            ->select(DB::raw('TRUNCATE(SUM(BeforeTaxCost),2) as TotalCost'))
            ->where('HeaderId', '=', $id)
            ->get();

        $dsbeg = DsBegining::find($id);
        $createddateval=$dsbeg->created_at;

        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $createddateval)->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');

        $bgHeader=DB::select('SELECT dsbeginings.id,dsbeginings.StoreId,dsbeginings.DocumentNumber,stores.Name as Store,fiscalyear.Monthrange AS FiscalYearRange,dsbeginings.Date,dsbeginings.FiscalYear,dsbeginings.CountedBy,dsbeginings.EndingDocumentNo,dsbeginings.CountedDate,dsbeginings.VerifiedBy,dsbeginings.VerifiedDate,dsbeginings.PostedBy,dsbeginings.PostedDate,dsbeginings.Status,dsbeginings.Memo,"'.$datetime.'" AS created_at FROM dsbeginings INNER JOIN stores as stores ON dsbeginings.StoreId=stores.id INNER JOIN fiscalyear ON dsbeginings.FiscalYear=fiscalyear.FiscalYear where dsbeginings.id='.$id);
        return response()->json(['bgHeader'=>$bgHeader,'pricing'=>$pricing]);       
    }

    public function showBeginingDetailData($id)
    {
        $detailTable=DB::select('SELECT dsbeginingdetails.id,dsbeginingdetails.ItemId,dsbeginingdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,dsbeginingdetails.Quantity,dsbeginingdetails.PartNumber,categories.Name as Category,uoms.Name as UOM,stores.Name as StoreName,(SELECT ROUND(regitems.WholesellerPrice/1.15,2)) AS MinSalePrice,dsbeginingdetails.Quantity,dsbeginingdetails.UnitCost,dsbeginingdetails.Memo,dsbeginingdetails.SerialNumberFlag,regitems.RequireSerialNumber,regitems.RequireExpireDate FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id inner join stores on dsbeginingdetails.StoreId=stores.id inner join uoms on regitems.MeasurementId=uoms.id inner join categories on regitems.CategoryId=categories.id where regitems.IsDeleted=1 AND dsbeginingdetails.HeaderId='.$id);
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            $btn="";
            if($data->RequireSerialNumber=='Not-Require' && $data->RequireExpireDate=='Not-Require'){
                $btn="";
            }
            else{
                $btn =  ' <a data-id="'.$data->id.'" class="btn btn-icon btn-gradient-info btn-sm addSerialNumber" data-toggle="modal" id="mediumButton" style="color: white;" title="Add Serial Numbers"><i class="fa fa-plus"></i></a>';
            }     
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showBeginingDetailPostedData($id)
    {
        $detailTable=DB::select('SELECT dsbeginingdetails.id,dsbeginingdetails.ItemId,dsbeginingdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,COALESCE(CONCAT((SELECT GROUP_CONCAT(BatchNumber," ") FROM serialandbatchnums WHERE header_id=dsbeginingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS BatchNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(SerialNumber," ") FROM serialandbatchnums WHERE header_id=dsbeginingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS SerialNumber,COALESCE(CONCAT((SELECT GROUP_CONCAT(ExpireDate," ") FROM serialandbatchnums WHERE header_id=dsbeginingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS ExpireDate,COALESCE(CONCAT((SELECT GROUP_CONCAT(ManufactureDate," ") FROM serialandbatchnums WHERE header_id=dsbeginingdetails.HeaderId AND item_id=regitems.id AND serialandbatchnums.TransactionType=1)),"") AS ManufactureDate,regitems.SKUNumber AS SKUNumber,dsbeginingdetails.Quantity,dsbeginingdetails.PartNumber,categories.Name as Category,uoms.Name as UOM,stores.Name as StoreName,dsbeginingdetails.Quantity,dsbeginingdetails.UnitCost,dsbeginingdetails.BeforeTaxCost,dsbeginingdetails.TotalCost,dsbeginingdetails.Memo FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id inner join stores on dsbeginingdetails.StoreId=stores.id inner join uoms on regitems.MeasurementId=uoms.id inner join categories on regitems.CategoryId=categories.id where dsbeginingdetails.HeaderId='.$id.' and dsbeginingdetails.Quantity!=0 and dsbeginingdetails.UnitCost!=0');
        return datatables()->of($detailTable)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showBgItemInfoCon($itemId,$strid,$headerid)
    {
        $ItemId=$itemId;
        $getItemCount=DB::select('SELECT COUNT(ItemId) AS ItemCount from dsbeginingdetails WHERE dsbeginingdetails.Quantity IS NOT NULL AND dsbeginingdetails.StoreId='.$strid.' AND dsbeginingdetails.HeaderId='.$headerid.' AND dsbeginingdetails.ItemId='.$itemId);

        foreach($getItemCount as $row)
        {
                $avaq=$row->ItemCount;
        }

        $avaqp = (float)$avaq;
        if($avaqp>=1)
        {
            return Response::json(['valerror' =>  "error"]);  
        }
        else
        {
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;
            $Regitem=DB::select('SELECT regitems.id,regitems.Type,regitems.Code,regitems.Name,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus FROM `regitems` INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.id='.$itemId);
            $getCost=DB::select('SELECT UnitCost FROM dsbeginingdetails WHERE dsbeginingdetails.ItemId='.$itemId.' AND dsbeginingdetails.HeaderId IN(SELECT id FROM dsbeginings WHERE dsbeginings.FiscalYear='.$fiscalyr.') ORDER BY UnitCost DESC LIMIT 1');
            if($getCost==null)
            {
                $getLastCost=0;
            }
            foreach($getCost as $row)
            {
                if($row!=null)
                {
                    $getLastCost=$row->UnitCost;
                }
                if($row==null)
                {
                    $getLastCost="";
                }
                if($row=="")
                {
                    $getLastCost="";
                }
            }
            return response()->json(['Regitem'=>$Regitem,'cost'=>$getLastCost]);
        }
        
    }

    public function showAdjustmentData($id)
    {
        $detailTable=DB::select('SELECT dsbeginingdetails.id,dsbeginingdetails.ItemId,dsbeginingdetails.HeaderId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,regitems.WholesellerPrice AS WholesellerPrice,dsbeginingdetails.Quantity,dsbeginingdetails.PartNumber,categories.Name as Category,uoms.Name as UOM,stores.Name as StoreName,dsbeginingdetails.Quantity,dsbeginingdetails.UnitCost,dsbeginingdetails.BeforeTaxCost,dsbeginingdetails.TotalCost,dsbeginingdetails.Memo FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id inner join stores on dsbeginingdetails.StoreId=stores.id inner join uoms on regitems.MeasurementId=uoms.id inner join categories on regitems.CategoryId=categories.id where dsbeginingdetails.HeaderId='.$id.' and dsbeginingdetails.Quantity!=0 and dsbeginingdetails.UnitCost!=0');
        if(request()->ajax()) {
            return datatables()->of($detailTable)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $btn =  ' <a data-id="'.$data->id.'" data-itemid="'.$data->ItemId.'" data-itemname="'.$data->ItemName.'" data-uom="'.$data->UOM.'" data-wholesale="'.$data->WholesellerPrice.'" class="btn btn-icon btn-gradient-info btn-sm editPosted" data-toggle="modal" id="mediumButton" data-target="" style="color: white;" title="Adjust Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-itemid="'.$data->ItemId.'" data-itemname="'.$data->ItemName.'" data-uom="'.$data->UOM.'" data-wholesale="'.$data->WholesellerPrice.'" class="btn btn-icon btn-gradient-danger btn-sm deletedPosted" data-toggle="modal" id="delButton" data-target="" style="color: white;" title="Remove Record"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function editSingleItem($id)
    {
        $begdetail = dsbeginingdetail::find($id);
        $itemid=$begdetail->ItemId;
        $items=Regitem::find($itemid);
        $ItemName=$items->Name;
        $uomid=$items->MeasurementId;
        $uoms=uom::find($uomid);
        return response()->json(['begdetail'=>$begdetail,$ItemName]);
    }

    public function syncBgItems(Request $request)
    {
        $begId=$request->recbgId;
        $begStoreId=$request->recbgStrId;
        $getSyncCount=DB::select('SELECT COUNT(id) AS Count FROM regitems WHERE id NOT IN (SELECT ItemId FROM dsbeginingdetails WHERE dsbeginingdetails.StoreId='.$begStoreId.' AND dsbeginingdetails.HeaderId='.$begId.') AND regitems.Type!="Service" AND regitems.IsDeleted=1');
        $syncToBeginingDetail=DB::select('INSERT INTO dsbeginingdetails(HeaderId,ItemId,ItemType,StoreId,TransactionType)SELECT '.$begId.',Id,Type,'.$begStoreId.',"Begining" from regitems where NOT EXISTS(SELECT ItemId FROM dsbeginingdetails WHERE (regitems.Id=dsbeginingdetails.ItemId AND dsbeginingdetails.StoreId='.$begStoreId.' AND dsbeginingdetails.HeaderId='.$begId.')) AND IsDeleted=1 AND Type!="Service"');
        return Response::json(['success' => $begId,'syncCount'=>$getSyncCount]);
    }

    public function postItem(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $itemid=$request->Item;
        $storeid=$request->storeidadj;
        $headerid=$request->headeridi;
        $quantity=$request->beginingQuantity;
        $unitcost=$request->BeginingUnitCost;
        $totalcost=$request->TotalCost;

        $validator = Validator::make($request->all(), [
            'Item' => ['required'],
            'beginingQuantity' => ['required','gt:0'],
            'BeginingUnitCost' => ['required','gt:0'], 
        ]);
        if ($validator->passes()) 
        {
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;

            $transactiontype="Begining";
            DB::table('dsbeginingdetails')
            ->where('HeaderId',$headerid)
            ->where('StoreId',$storeid)
            ->where('ItemId',$itemid)
            ->update(['Quantity'=>$quantity,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$totalcost,'TaxAmount'=>(DB::raw('(dsbeginingdetails.BeforeTaxCost * 15)/100')),'TotalCost'=>(DB::raw('dsbeginingdetails.BeforeTaxCost + dsbeginingdetails.TaxAmount')),'TransactionType'=>$transactiontype,'Date'=>Carbon::now()]);
           
            $updateCost=DB::select('UPDATE dsbeginingdetails SET UnitCost='.$unitcost.',BeforeTaxCost=dsbeginingdetails.Quantity * dsbeginingdetails.UnitCost,TaxAmount=(dsbeginingdetails.BeforeTaxCost * 15)/100,TotalCost=dsbeginingdetails.BeforeTaxCost + dsbeginingdetails.TaxAmount WHERE ItemId='.$itemid.' AND HeaderId IN(SELECT id FROM dsbeginings WHERE FiscalYear='.$fiscalyr.')');

            $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType'
                ],
                function ($query)use($headerid,$storeid,$itemid) {
                    $query
                        ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','ItemType']) // ..., columnN
                        ->from('dsbeginingdetails')->where('HeaderId', '=',$headerid)->where('StoreId', '=',$storeid)->where('ItemId', '=',$itemid)->whereNotNull('Quantity');
                }
            );
            $bgcon = DB::table('dsbeginings')->where('id', $headerid)->latest()->first();
            $docnum=$bgcon->DocumentNumber;
            $transactiontype="Begining";

            DB::table('deadstocktransaction')
            ->where('HeaderId', $headerid)
            ->where('TransactionType',$transactiontype)
            ->update(['DocumentNumber' => $docnum,'FiscalYear'=>$fiscalyr,'TransactionsType'=>$transactiontype,'Date'=>Carbon::today()->toDateString()]);
            
            $updatetransactionCost=DB::select('UPDATE deadstocktransaction SET UnitCost='.$unitcost.',BeforeTaxCost=deadstocktransaction.StockIn * deadstocktransaction.UnitCost,TaxAmountCost=(deadstocktransaction.BeforeTaxCost * 15)/100,TotalCost=deadstocktransaction.BeforeTaxCost + deadstocktransaction.TaxAmountCost WHERE ItemId='.$itemid.' AND FiscalYear='.$fiscalyr.' AND TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND StockIn IS NOT NULL');

            DB::table('dsbeginings')
            ->where('id', $headerid)
            ->update(['AdjustedBy' => $user,'AdjustedDate'=>Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A')]);

            $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT TRUNCATE(COALESCE(MAX(UnitCost*1.15),0),2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId)');
            $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT TRUNCATE(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId AND deadstocktransaction.TransactionsType IN("Begining","Receiving","Adjustment"))');
            $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT TRUNCATE(COALESCE(MIN(UnitCost*1.15),0),2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId)');
           
            return Response::json(['success' => '1','hid'=>$headerid]);
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function editPostedSingleItem(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $itemid=$request->itemidi;
        $storeid=$request->storeidadj;
        $headerid=$request->headeridi;
        $quantity=$request->beginingQuantity;
        $unitcost=$request->BeginingUnitCost;
        $totalcost=$request->TotalCost;
        $tempval=[];
        $result="0";
        $cval="0";
        $singleqnt="";
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $validator = Validator::make($request->all(), [
            'beginingQuantity' => ['required','gt:0'],
            'BeginingUnitCost' => ['required','gt:0'], 
        ]);
        if ($validator->passes()) 
        {
            $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS dsbegtemp'.$userid.''));
            $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE dsbegtemp'.$userid.' SELECT deadstocktransaction.id,deadstocktransaction.HeaderId,deadstocktransaction.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,deadstocktransaction.StoreId,uoms.Name AS UOM,deadstocktransaction.StockIn,deadstocktransaction.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY deadstocktransaction.ItemId,deadstocktransaction.StoreId ORDER BY deadstocktransaction.id ASC)) AS AvailableQuantity,deadstocktransaction.TransactionsType,deadstocktransaction.FiscalYear FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id INNER JOIN stores ON deadstocktransaction.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE deadstocktransaction.ItemId IN(SELECT dsbeginingdetails.ItemId FROM dsbeginingdetails WHERE dsbeginingdetails.HeaderId='.$request->headeridi.') AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.ItemId='.$itemid.'');
            $updatestockingquantity=DB::select('update dsbegtemp'.$userid.' set StockIn='.$quantity.' where HeaderId='.$request->headeridi.' AND TransactionsType="Begining" AND ItemId='.$itemid.' AND StoreId='.$storeid.'');
            $gettemptable=DB::select('SELECT dsbegtemp'.$userid.'.id,dsbegtemp'.$userid.'.HeaderId,dsbegtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dsbegtemp'.$userid.'.StoreId,uoms.Name AS UOM,dsbegtemp'.$userid.'.StockIn,dsbegtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dsbegtemp'.$userid.'.ItemId,dsbegtemp'.$userid.'.StoreId ORDER BY dsbegtemp'.$userid.'.id ASC)) AS AvailableQuantity,dsbegtemp'.$userid.'.TransactionsType FROM dsbegtemp'.$userid.' INNER JOIN regitems ON dsbegtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dsbegtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dsbegtemp'.$userid.'.ItemId='.$itemid.' AND dsbegtemp'.$userid.'.StoreId='.$storeid.'');
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM dsbeginingdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId ='.$itemid.') WHERE trs.HeaderId='.$headerid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.FiscalYear='.$fiscalyr.'),0)-'.$quantity.')<0');
            $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.TransactionType!="Begining" AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.FiscalYear='.$fiscalyr);
            $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.FiscalYear='.$fiscalyr);
            foreach($gettemptable as $row)
            {
                $tempval[]=$row->AvailableQuantity;
                $singleqnt=$row->AvailableQuantity;
                if($singleqnt<0){
                    $result+=1;
                }
            }
            if($singleqnt<0){
                $cval+=1;
            } 
            // foreach($stockin as $row)
            // {
            //     $stockin=$row->StockIn;
            // }
            // foreach($stockout as $row)
            // {
            //     $stockout=$row->StockOut;
            // }
            // $stockin = (float)$stockin;
            // $stockout = (float)$stockout;
            // $result=($stockin+$quantity)-($stockout);
            $results= (float)$result;
            $cvals= (float)$cval;
            if($results>=1||$cvals>=1)
            {
                return Response::json(['valerror' =>  "error",'countedval'=>$result]);
            }
            else if($results==0 && $cvals==0)
            {
                $transactiontype="Begining";
                DB::table('dsbeginingdetails')
                ->where('HeaderId',$headerid)
                ->where('StoreId',$storeid)
                ->where('ItemId',$itemid)
                ->update(['Quantity'=>$quantity,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$totalcost,'TaxAmount'=>(DB::raw('(dsbeginingdetails.BeforeTaxCost * 15)/100')),'TotalCost'=>(DB::raw('dsbeginingdetails.BeforeTaxCost + dsbeginingdetails.TaxAmount')),'TransactionType'=>$transactiontype,'Date'=>Carbon::now()]);
                
                $updateCost=DB::select('UPDATE dsbeginingdetails SET UnitCost='.$unitcost.',BeforeTaxCost=dsbeginingdetails.Quantity * dsbeginingdetails.UnitCost,TaxAmount=(dsbeginingdetails.BeforeTaxCost * 15)/100,TotalCost=dsbeginingdetails.BeforeTaxCost + dsbeginingdetails.TaxAmount WHERE ItemId='.$itemid.' AND HeaderId IN(SELECT id FROM dsbeginings WHERE FiscalYear='.$fiscalyr.')');

                $bgcon = DB::table('dsbeginings')->where('id', $headerid)->latest()->first();
                $docnum=$bgcon->DocumentNumber;

                DB::table('deadstocktransaction')
                ->where('HeaderId',$headerid)
                ->where('StoreId',$storeid)
                ->where('ItemId',$itemid)
                ->where('TransactionType',$transactiontype)
                ->where('TransactionsType',$transactiontype)
                ->where('DocumentNumber',$docnum)
                ->update(['StockIn'=>$quantity,'UnitCost'=>$unitcost,'BeforeTaxCost'=>$totalcost,'TaxAmountCost'=>(DB::raw('(deadstocktransaction.BeforeTaxCost * 15)/100')),'TotalCost'=>(DB::raw('deadstocktransaction.BeforeTaxCost + deadstocktransaction.TaxAmountCost'))]);
                
                $updatetransactionCost=DB::select('UPDATE deadstocktransaction SET UnitCost='.$unitcost.',BeforeTaxCost=deadstocktransaction.StockIn * deadstocktransaction.UnitCost,TaxAmountCost=(deadstocktransaction.BeforeTaxCost * 15)/100,TotalCost=deadstocktransaction.BeforeTaxCost + deadstocktransaction.TaxAmountCost WHERE ItemId='.$itemid.' AND FiscalYear='.$fiscalyr.' AND TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND StockIn IS NOT NULL');

                DB::table('dsbeginings')
                ->where('id', $headerid)
                ->update(['AdjustedBy' => $user,'AdjustedDate'=>Carbon::today()->toDateString()]);
    
                $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT TRUNCATE(COALESCE(MAX(UnitCost*1.15),0),2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId)');
                $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT TRUNCATE(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId AND deadstocktransaction.TransactionsType IN("Begining","Receiving","Adjustment"))');
                $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT TRUNCATE(COALESCE(MIN(UnitCost*1.15),0),2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId)');
                return Response::json(['success' => '1','StockIn'=>$stockin,'StockOut'=>$stockout,'result'=>$result]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function deletePostedSingleItem(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $itemid=$request->removeItemId;
        $storeid=$request->removeStoreId;
        $headerid=$request->removeHeaderId;
        $quantity=$request->removeItemQuantity;
        $removeRecdId=$request->removeRecordId;
        $tempval=[];
        $result="0";
        $cval="0";
        $singleqnt="";
        //dd($request->all());
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;

        $validator = Validator::make($request->all(), [
        ]);
        if ($validator->passes()) 
        {
            $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS dsbegtemp'.$userid.''));
            $creatingtemptables =DB::statement('CREATE TEMPORARY TABLE dsbegtemp'.$userid.' SELECT deadstocktransaction.id,deadstocktransaction.HeaderId,deadstocktransaction.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,deadstocktransaction.StoreId,uoms.Name AS UOM,deadstocktransaction.StockIn,deadstocktransaction.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY deadstocktransaction.ItemId,deadstocktransaction.StoreId ORDER BY deadstocktransaction.id ASC)) AS AvailableQuantity,deadstocktransaction.TransactionsType,deadstocktransaction.FiscalYear FROM deadstocktransaction INNER JOIN regitems ON deadstocktransaction.ItemId=regitems.id INNER JOIN stores ON deadstocktransaction.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE deadstocktransaction.ItemId IN(SELECT dsbeginingdetails.ItemId FROM dsbeginingdetails WHERE dsbeginingdetails.HeaderId='.$request->removeHeaderId.') AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.ItemId='.$itemid.'');
            $updatestockingquantity=DB::select('update dsbegtemp'.$userid.' set StockIn="0" where HeaderId='.$request->removeHeaderId.' AND TransactionsType="Begining" AND ItemId='.$itemid.' AND StoreId='.$storeid.'');
            $gettemptable=DB::select('SELECT dsbegtemp'.$userid.'.id,dsbegtemp'.$userid.'.HeaderId,dsbegtemp'.$userid.'.ItemId,regitems.Code AS ItemCode,regitems.Name AS ItemName,regitems.SKUNumber AS SKUNumber,stores.Name AS StoreName,dsbegtemp'.$userid.'.StoreId,uoms.Name AS UOM,dsbegtemp'.$userid.'.StockIn,dsbegtemp'.$userid.'.StockOut,(SUM(COALESCE(StockIn,0)-COALESCE(StockOut,0))OVER(PARTITION BY dsbegtemp'.$userid.'.ItemId,dsbegtemp'.$userid.'.StoreId ORDER BY dsbegtemp'.$userid.'.id ASC)) AS AvailableQuantity,dsbegtemp'.$userid.'.TransactionsType FROM dsbegtemp'.$userid.' INNER JOIN regitems ON dsbegtemp'.$userid.'.ItemId=regitems.id INNER JOIN stores ON dsbegtemp'.$userid.'.StoreId=stores.id INNER JOIN uoms ON regitems.MeasurementId=uoms.Id WHERE dsbegtemp'.$userid.'.ItemId='.$itemid.' AND dsbegtemp'.$userid.'.StoreId='.$storeid.'');
            $getApprovedQuantity=DB::select('SELECT COUNT(DISTINCT trs.ItemId) AS ApprovedItems FROM dsbeginingdetails AS trs INNER JOIN regitems ON trs.ItemId=regitems.id JOIN deadstocktransaction AS trn ON (trs.ItemId ='.$itemid.') WHERE trs.HeaderId='.$headerid.' AND (SELECT COALESCE((select sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0)) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=trs.ItemId AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.FiscalYear='.$fiscalyr.'),0)-'.$quantity.')<0');
            $stockin=DB::select('SELECT sum(COALESCE(StockIn,0)) AS StockIn FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.FiscalYear='.$fiscalyr);
            $stockout=DB::select('SELECT sum(COALESCE(StockOut,0)) AS StockOut FROM deadstocktransaction WHERE deadstocktransaction.ItemId='.$itemid.' AND deadstocktransaction.StoreId='.$storeid.' AND deadstocktransaction.FiscalYear='.$fiscalyr);
            foreach($gettemptable as $row)
            {
                $tempval[]=$row->AvailableQuantity;
                $singleqnt=$row->AvailableQuantity;
                if($singleqnt<0){
                    $result+=1;
                }
            }
            if($singleqnt<0){
                $cval+=1;
            } 
            // foreach($stockin as $row)
            // {
            //     $stockin=$row->StockIn;
            // }
            // foreach($stockout as $row)
            // {
            //     $stockout=$row->StockOut;
            // }
            // $stockin = (float)$stockin;
            // $stockout = (float)$stockout;
            // $result=($stockin-$stockout)-($quantity);
            $results= (float)$result;
            $cvals= (float)$cval;
            if($results>=1||$cvals>=1)
            {
                return Response::json(['valerror' =>  "error",'countedval'=>$result]);
            }
            else if($results==0 && $cvals==0)
            {
                $transactiontype="Begining";
                $removeBegining=DB::select('DELETE FROM dsbeginingdetails WHERE id='.$removeRecdId);
                $bgcon = DB::table('dsbeginings')->where('id', $headerid)->latest()->first();
                $docnum=$bgcon->DocumentNumber;
                $removeTransaction=DB::select('DELETE FROM deadstocktransaction WHERE TransactionType="'.$transactiontype.'" AND TransactionsType="'.$transactiontype.'" AND HeaderId='.$headerid.' AND StoreId='.$storeid.' AND ItemId='.$itemid.' AND DocumentNumber="'.$docnum.'"');
                DB::table('dsbeginings')
                ->where('id', $headerid)
                ->update(['AdjustedBy' => $user,'AdjustedDate'=>Carbon::today()->toDateString()]);
                $dropTable=DB::unprepared( DB::raw('DROP TEMPORARY TABLE IF EXISTS dsbegtemp'.$userid.''));
                return Response::json(['success' => '1','StockIn'=>$stockin,'StockOut'=>$stockout,'result'=>$result]);
            }
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function syncBgCost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SyncStore' => ['required'],
        ]);
        if ($validator->passes())
        {
            $headerId=$request->syncheaderid;
            $storeId=$request->SyncStore;
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;
            $headerStoreVal = DB::table('dsbeginings')->where('FiscalYear',$fiscalyr)->where('StoreId',$storeId)->latest()->first();
            $ids=$headerStoreVal->id;
            $getSyncCount=DB::select('select COUNT(UnitCost) AS Count FROM dsbeginingdetails WHERE dsbeginingdetails.HeaderId='.$ids.' AND dsbeginingdetails.UnitCost IS NOT NULL');
            $updateCost=DB::select('UPDATE dsbeginingdetails as b1 INNER JOIN dsbeginingdetails as b2 ON b1.ItemId = b2.ItemId AND b2.HeaderId='.$ids.' AND b2.UnitCost IS NOT NULL SET b1.UnitCost = b2.UnitCost WHERE b1.HeaderId='.$headerId);
            return Response::json(['success' =>'1','syncCount'=>$getSyncCount]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function quantityUpdate($id,$data)
    {
        try
        {
            $begin=dsbeginingdetail::find($id);
            $qnts=$begin->Quantity;
            if($qnts!=$data && $data!=-1)
            {
                $bgdetail=dsbeginingdetail::findorFail($id);
                $bgdetail->Quantity=$data;
                $bgdetail->SerialNumberFlag=0;
                $bgdetail->save();
                return Response::json(['success' => '1']);
            }
            if($qnts==$data && $data!=-1)
            {
                $bgdetail=dsbeginingdetail::findorFail($id);
                $bgdetail->Quantity=$data;
                $bgdetail->save();
                return Response::json(['success' => '1']);
            }
            if($data=='-1')
            {
                $bgdetail=dsbeginingdetail::findorFail($id);
                $bgdetail->Quantity=null;
                $bgdetail->save();
                return Response::json(['success' => '1']);
            }
        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }   
    }

    public function unitcostUpdate($id,$data)
    {
        try
        {
            if($data!=-1)
            {
                $bgdetail=dsbeginingdetail::findorFail($id);
                $bgdetail->UnitCost=$data;
                $bgdetail->save();
                return Response::json(['success' =>'12']);
            }
           if($data=='-1')
           {
                $varuc=null;
                $bgdetail=dsbeginingdetail::findorFail($id);
                $bgdetail->UnitCost=null;
                $bgdetail->save();
                return Response::json(['success' =>'null']);
           }

        }
        catch(Exception $e)
        {
            return Response::json(['dberrors' =>  $e->getMessage()]);
        }        
    }

    public function countDone(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->doneid;
        $getCountedQuantity=DB::select('SELECT COUNT(ItemId) AS ItemCount FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE (regitems.RequireSerialNumber="Require" OR regitems.RequireExpireDate="Require-BatchNumber" OR regitems.RequireExpireDate="Require-Both" OR regitems.RequireExpireDate="Require-ExpireDate") AND dsbeginingdetails.SerialNumberFlag=0 AND (dsbeginingdetails.Quantity!=0 OR dsbeginingdetails.Quantity!=NULL) AND dsbeginingdetails.HeaderId='.$findid);
        foreach($getCountedQuantity as $row)
        {
            $countval=$row->ItemCount;
        }
        $countvals = (float)$countval;
        if($countvals>=1)
        {
            $getUnfinishedItemName=DB::select('SELECT regitems.Name AS ItemName FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE (regitems.RequireSerialNumber="Require" OR regitems.RequireExpireDate="Require-BatchNumber" OR regitems.RequireExpireDate="Require-Both" OR regitems.RequireExpireDate="Require-ExpireDate") AND dsbeginingdetails.SerialNumberFlag=0 AND (dsbeginingdetails.Quantity!=0 OR dsbeginingdetails.Quantity!=NULL) AND dsbeginingdetails.HeaderId='.$findid.' ORDER BY regitems.Name ASC');
            return Response::json(['valerror' =>  "error",'countItems'=>$getUnfinishedItemName,'countedval'=>$countvals]);
        }
        else{
            $bg=DsBegining::find($findid);
            $bg->Status="Done";
            $bg->CountedBy= $user;
            $bg->CountedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            // $bg->CountedDate=Carbon::today()->toDateString();
            $bg->save();
        }
        return Response::json(['success' => '1']);
    }

    public function countVerify(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->verifyid;
        $getCountedQuantity=DB::select('SELECT COUNT(ItemId) AS ItemCount FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE (regitems.RequireSerialNumber="Require" OR regitems.RequireExpireDate="Require-BatchNumber" OR regitems.RequireExpireDate="Require-Both" OR regitems.RequireExpireDate="Require-ExpireDate") AND dsbeginingdetails.SerialNumberFlag=0 AND (dsbeginingdetails.Quantity!=0 OR dsbeginingdetails.Quantity!=NULL) AND dsbeginingdetails.HeaderId='.$findid);
        foreach($getCountedQuantity as $row)
        {
            $countval=$row->ItemCount;
        }
        $countvals = (float)$countval;
        if($countvals>=1)
        {
            $getUnfinishedItemName=DB::select('SELECT regitems.Name AS ItemName FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE (regitems.RequireSerialNumber="Require" OR regitems.RequireExpireDate="Require-BatchNumber" OR regitems.RequireExpireDate="Require-Both" OR regitems.RequireExpireDate="Require-ExpireDate") AND dsbeginingdetails.SerialNumberFlag=0 AND (dsbeginingdetails.Quantity!=0 OR dsbeginingdetails.Quantity!=NULL) AND dsbeginingdetails.HeaderId='.$findid.' ORDER BY regitems.Name ASC');
            return Response::json(['valerror' =>  "error",'countItems'=>$getUnfinishedItemName,'countedval'=>$countvals]);
        }
        else
        {
            $bg=DsBegining::find($findid);
            $bg->Status="Verified";
            $bg->VerifiedBy= $user;
            $bg->VerifiedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $bg->save();
        }
        return Response::json(['success' => '1']);
    }

    public function countComment(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->commentid;
        $bg=DsBegining::find($findid);
        $validator = Validator::make($request->all(), [
            'Comment'=>"required",
        ]);
        if ($validator->passes())
        { 
            $bg->Memo=trim($request->input('Comment'));
            $bg->Status="Counting";
            $bg->save();
            return Response::json(['success' => '1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function countPost(Request $request)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $findid=$request->postid;
        $rec=DsBegining::find($findid);
        $getCountedQuantity=DB::select('SELECT COUNT(ItemId) AS ItemCount FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE (regitems.RequireSerialNumber="Require" OR regitems.RequireExpireDate="Require-BatchNumber" OR regitems.RequireExpireDate="Require-Both" OR regitems.RequireExpireDate="Require-ExpireDate") AND dsbeginingdetails.SerialNumberFlag=0 AND (dsbeginingdetails.Quantity!=0 OR dsbeginingdetails.Quantity!=NULL) AND dsbeginingdetails.HeaderId='.$findid);
        foreach($getCountedQuantity as $row)
        {
            $countval=$row->ItemCount;
        }
        $countvals = (float)$countval;

        $getUnfinishedItem=DB::select('SELECT COUNT(HeaderId) AS CountItem from dsbeginingdetails WHERE HeaderId='.$findid.' AND (Quantity IS NOT null OR Quantity!=0) AND (UnitCost IS null OR UnitCost=0)');
        foreach($getUnfinishedItem as $row)
        {
             $countedval=$row->CountItem;
        }
        if($countedval>0)
        {
            $getUnfinishedItemName=DB::select('SELECT regitems.Name AS ItemName from dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE HeaderId='.$findid.' AND (Quantity IS NOT null OR Quantity!=0) AND (UnitCost IS null OR UnitCost=0) ORDER BY ItemName ASC');
            return Response::json(['counterror' =>  "error",'countedval'=>$countedval,'countItems'=>$getUnfinishedItemName]);
        }
        if($countvals>=1)
        {
            $getUnfinishedItemName=DB::select('SELECT regitems.Name AS ItemName FROM dsbeginingdetails INNER JOIN regitems ON dsbeginingdetails.ItemId=regitems.id WHERE (regitems.RequireSerialNumber="Require" OR regitems.RequireExpireDate="Require-BatchNumber" OR regitems.RequireExpireDate="Require-Both" OR regitems.RequireExpireDate="Require-ExpireDate") AND dsbeginingdetails.SerialNumberFlag=0 AND (dsbeginingdetails.Quantity!=0 OR dsbeginingdetails.Quantity!=NULL) AND dsbeginingdetails.HeaderId='.$findid.' ORDER BY regitems.Name ASC');
            return Response::json(['valerror' =>  "error",'countItems'=>$getUnfinishedItemName,'countedval'=>$countvals]);
        }
        else
        {
            DB::table('dsbeginingdetails')
            ->where('HeaderId', $findid)
            ->update(['BeforeTaxCost' =>(DB::raw('(dsbeginingdetails.Quantity * dsbeginingdetails.UnitCost)')),'TaxAmount'=>(DB::raw('(dsbeginingdetails.BeforeTaxCost * 15)/100')),'TotalCost' =>(DB::raw('dsbeginingdetails.BeforeTaxCost + dsbeginingdetails.TaxAmount'))]);
            
            $updateRound=DB::select('UPDATE dsbeginingdetails SET dsbeginingdetails.BeforeTaxCost=TRUNCATE((dsbeginingdetails.BeforeTaxCost),2),dsbeginingdetails.TaxAmount=TRUNCATE((dsbeginingdetails.TaxAmount),2),dsbeginingdetails.TotalCost=TRUNCATE((dsbeginingdetails.TotalCost),2)');
            $transactiondata=DB::table('deadstocktransaction')->insertUsing(
                ['HeaderId', 'ItemId', 'StockIn','UnitCost','BeforeTaxCost','TaxAmountCost','TotalCost','StoreId','TransactionType','ItemType'
                ],
                function ($query)use($findid) {
                    $query
                        ->select(['HeaderId', 'ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','TransactionType','ItemType']) // ..., columnN
                        ->from('dsbeginingdetails')->where('HeaderId', '=',$findid)->where('Quantity', '!=','0')->where('UnitCost', '!=','0')->whereNotNull('Quantity');
                }
            );

            $bgcon = DB::table('dsbeginings')->where('id', $findid)->latest()->first();
            $docnum=$bgcon->DocumentNumber;
            $transactiontype="Begining";
        
            $settingsval = DB::table('settings')->latest()->first();
            $fiscalyr=$settingsval->FiscalYear;

            DB::table('deadstocktransaction')
            ->where('HeaderId', $findid)
            ->where('TransactionType',$transactiontype)
            ->update(['DocumentNumber' => $docnum,'FiscalYear'=>$fiscalyr,'TransactionsType'=>$transactiontype,'Date'=>Carbon::today()->toDateString()]);

            $rec->Status="Posted";
            $rec->PostedBy= $user;
            $rec->PostedDate=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('Y-m-d @ g:i:s A');
            $rec->save();
            $trtype="Void";
            $undotransaction="Undo-Void";
            $updateMaxCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.MaxCost = (SELECT TRUNCATE(COALESCE(MAX(UnitCost*1.15),0),2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId)');
            $updateAverageCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.averageCost = (SELECT TRUNCATE(COALESCE(SUM(BeforeTaxCost),0)/(COALESCE(SUM(StockIn),0))*1.15,2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId AND deadstocktransaction.TransactionsType IN("Begining","Receiving","Adjustment"))');
            $updateMinCost=DB::select('UPDATE regitems as b1 INNER JOIN deadstocktransaction as b2 ON b1.id = b2.ItemId SET b1.minCost = (SELECT TRUNCATE(COALESCE(MIN(UnitCost*1.15),0),2) FROM deadstocktransaction WHERE deadstocktransaction.ItemId=b2.ItemId)');
            $updateSerNum=DB::select('UPDATE serialandbatchnums SET IsConfirmed=1 WHERE header_id='.$findid.' AND TransactionType=1');
            $syncToSerialNumberHistory=DB::select('INSERT INTO serialnumberhistories(serialnumheader_id,transactionheader_id,DocumentNumber,TransactionType,TransactionDate)SELECT id,'.$findid.',"'.$docnum.'","1","'.Carbon::today()->toDateString().'" from serialandbatchnums where header_id='.$findid.' AND TransactionType=1');
            return Response::json(['success' =>'1']);
        }
    }

    public function getBeginingNumber()
    {
        $settings = DB::table('settings')->latest()->first();
        $bprefix=$settings->AdjustmentPrefix;
        $bnumber=$settings->AdjustmentNumber;
        $numberPadding=sprintf("%06d", $bnumber);
        $begNumber=$bprefix.$numberPadding;
        $updn=DB::select('update countable set AdjustmentCount=AdjustmentCount+1 where id=1');
        $reqCountNum = DB::table('countable')->latest()->first();
        return response()->json(['adjnum'=>$adjNumber,'AdjustmentCount'=>$reqCountNum->AdjustmentCount]);
    }

    public function showSerialNumberConBg($id)
    {
        $recdataId = dsbeginingdetail::find($id);
        $itemid=$recdataId->ItemId;
        $storeid=$recdataId->StoreId;
        $itemProp = Regitem::find($itemid);
        $itemname=$itemProp->Name;
        $reqsn=$itemProp->RequireSerialNumber;
        $reqed=$itemProp->RequireExpireDate;
        $countedVal=DB::select('SELECT COUNT(item_id) AS ItemCount FROM serialandbatchnums WHERE item_id='.$itemid.' AND store_id='.$storeid.' AND TransactionType=1');
        foreach($countedVal as $row)
        {
            $cnt=$row->ItemCount;
        }
        $cnts = (float)$cnt;
        return response()->json(['recDataId'=>$recdataId,'itemname'=>$itemname,'reqsn'=>$reqsn,'reqed'=>$reqed,'cnts'=>$cnts,'id'=>$id]);
    }

    public function addSerialnumberConBg(Request $request)
    {
        $itemid=$request->seritemid;
        $headerid=$request->serheaderid;
        $storeid=$request->serstoreid;
        $storeqnt=$request->storeQuantity;
        $tableids=$request->tableid;
        $qnt=$request->Quantity;
        $ItemInfo=Regitem::find($itemid);
        $reqSerialNum=$ItemInfo->RequireSerialNumber;
        $reqExpireDate=$ItemInfo->RequireExpireDate;
        $countitem = DB::table('serialandbatchnums')->where('header_id', '=', $headerid)->where('item_id', '=', $itemid)->where('TransactionType',1)->get();
        $getCountItems = $countitem->count();
        $citem = (float)$getCountItems;
        $qitem = (float)$storeqnt;
        $scount = (float)$storeqnt;
        $qcount = (float)$qnt;
        $remvalue=$scount-$citem;
        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'modelNumber' => 'required',
            'ManufactureDate' => 'nullable|before:today',
        ]);
        $validator->sometimes('SerialNumber','required|nullable|unique:serialandbatchnums,SerialNumber,'.$tableids, function($request) {
            return ($request->serialnumreq=='Require');
        });

        $validator->sometimes('BatchNumber', 'required', function($request) {
            return ($request->expirenumreq=='Require-Both'||$request->expirenumreq=='Require-BatchNumber');
        });

        $validator->sometimes('Quantity', 'required|gt:0', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->serialnumreq=='Require-BatchNumber');
        });

        $validator->sometimes('ExpireDate', 'required|after:today', function($request) {
            return ($request->expirenumreq=="Require-Both"||$request->expirenumreq=="Require-ExpireDate");
        });

        if($citem>=$qitem && $tableids==null)
        {
            return Response::json(['valerror' =>  "error"]);
        }
        if($validator->passes())
        {
            try
            {
                if($tableids==null){
                    if($remvalue>=$qcount){
                        for ($i = 1; $i <= $qcount; $i++ ) {
                            $ser=new serialandbatchnum;
                            $ser->header_id=$request->serheaderid;
                            $ser->item_id=$request->seritemid;
                            $ser->store_id=$request->serstoreid;
                            $ser->brand_id=$request->brand;
                            $ser->ModelName=$request->modelNumber;
                            $ser->ManufactureDate=$request->ManufactureDate;
                            $ser->ExpireDate=$request->ExpireDate;
                            $ser->SerialNumber=$request->SerialNumber;
                            $ser->BatchNumber=$request->BatchNumber;
                            $ser->IsIssued=0;
                            $ser->IsSold=0;
                            $ser->TransactionType=1;
                            $ser->TransactionDate=Carbon::today()->toDateString();
                            $ser->save();
                        }
                    }
                    else if($remvalue<$qcount){
                        return Response::json(['qnterror' =>  "error"]);
                    }
                    
                }
                else if($tableids!=null){
                    $sernum=serialandbatchnum::updateOrCreate(['id' =>$request->tableid], [
                        'header_id' => $request->serheaderid,
                        'item_id' => $request->seritemid,
                        'store_id' => $request->serstoreid,
                        'brand_id' => $request->brand,
                        'ModelName' => $request->modelNumber,
                        'ManufactureDate' => $request->ManufactureDate,
                        'ExpireDate' => $request->ExpireDate,
                        'SerialNumber' => $request->SerialNumber,
                        'BatchNumber'=> $request->BatchNumber,
                        'IsIssued'=> 0,
                        'IsSold'=> 0,
                        'TransactionType'=>1,
                        'TransactionDate'=>Carbon::today()->toDateString(),
                    ]);
                }
                $countitem = DB::table('serialandbatchnums')->where('header_id', '=', $headerid)->where('item_id', '=', $itemid)->where('TransactionType',1)->get();
                $getCountItem = $countitem->count();
                $getSerialNum=DB::select('SELECT GROUP_CONCAT(SerialNumber ," ") AS SerialNumber FROM serialandbatchnums WHERE header_id='.$headerid.' AND item_id='.$itemid);
                foreach ($getSerialNum as $row) 
                {
                    $ser=$row->SerialNumber;
                }
                DB::table('dsbeginingdetails')
                ->where('HeaderId', $headerid)
                ->where('ItemId', $itemid)
                ->update(['SerialNumbers' => $ser]);
                if($qitem==$getCountItem)
                {
                    DB::table('dsbeginingdetails')
                    ->where('HeaderId', $headerid)
                    ->where('ItemId', $itemid)
                    ->update(['SerialNumberFlag' =>1]);
                }
                return Response::json(['success' => '1','Totalcount'=>$getCountItem,'TotalQ'=>$qitem,'ser'=>$ser,'brand'=>$request->brand]);   
            }
            catch(Exception $e)
            {
                return Response::json(['dberrors' =>  $e->getMessage()]);
            }     
        }
        if($validator->fails())
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    
    public function showModelsCon($id)
    {
        $model=DB::select('SELECT models.Name FROM models WHERE models.BrandId='.$id.' AND models.ActiveStatus="Active" AND models.IsDeleted=1');
        return response()->json(['model'=>$model]);  
    }

    public function showSerialNumbersBg($id,$nid,$trtype)
    {
        $sernum=DB::select('SELECT serialandbatchnums.id,header_id,item_id,store_id,brand_id AS BrandId,brands.Name AS BrandName,ModelName,ManufactureDate,ExpireDate,SerialNumber,BatchNumber,IsIssued,TransactionDate FROM serialandbatchnums INNER JOIN brands ON serialandbatchnums.brand_id=brands.id WHERE header_id='.$id.' and item_id='.$nid.' and TransactionType='.$trtype.' ORDER BY id DESC');
        return datatables()->of($sernum)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {     
                $btn =  ' <a class="btn btn-icon btn-gradient-info btn-sm editSN" data-id="'.$data->id.'" data-mod="'.$data->ModelName.'" data-toggle="modal" id="mediumButton" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                $btn = $btn.' <a data-id="'.$data->id.'" data-toggle="modal" id="smallButton" class="btn btn-icon btn-gradient-danger btn-sm" data-target="#sernumDeleteModal" data-attr="" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function editSerialNumberConBg($id)
    {
        $recdata = serialandbatchnum::find($id);
        return response()->json(['recData'=>$recdata]);
    }

    public function deleteSerialNumBg($id)
    {
        $sernum = serialandbatchnum::find($id);
        $headerid=$sernum->header_id;
        $itemid=$sernum->item_id;
        $sernum->delete();
        $getSerialNum=DB::select('SELECT GROUP_CONCAT(SerialNumber ," ") AS SerialNumber FROM serialandbatchnums WHERE header_id='.$headerid.' AND item_id='.$itemid.' AND TransactionType=1');
        foreach ($getSerialNum as $row) 
        {
            $sernum=$row->SerialNumber;
        }
       
        $getbegid=DB::select('SELECT Quantity FROM dsbeginingdetails WHERE HeaderId='.$headerid.' AND ItemId='.$itemid);
        foreach ($getbegid as $row) 
        {
            $qnts=$row->Quantity;
        }

        $countitem = DB::table('serialandbatchnums')->where('header_id', '=', $headerid)->where('item_id', '=', $itemid)->where('TransactionType',1)->get();
        $getCountItem = $countitem->count();
        if($qnts==$getCountItem){
            DB::table('dsbeginingdetails')
            ->where('HeaderId', $headerid)
            ->where('ItemId', $itemid)
            ->update(['SerialNumbers' => $sernum,'SerialNumberFlag' =>1]);
        }
        if($qnts!=$getCountItem){
            DB::table('dsbeginingdetails')
            ->where('HeaderId', $headerid)
            ->where('ItemId', $itemid)
            ->update(['SerialNumbers' => $sernum,'SerialNumberFlag' =>0]);
        }
        return Response::json(['success' => '1','Totalcount'=>$getCountItem,'qnt'=>$qnts,'cnt'=>$getCountItem]);
    }


    public function showBeginingDataFy($fy)
    {
        $user=Auth()->user()->username;
        $userid=Auth()->user()->id;
        $req=DB::select('SELECT dsbeginings.id,dsbeginings.DocumentNumber,dsbeginings.EndingDocumentNo,stores.Name as Store,dsbeginings.FiscalYear,fiscalyear.Monthrange AS FiscalYearRange,dsbeginings.Date,dsbeginings.Username,dsbeginings.Status FROM dsbeginings INNER JOIN stores ON dsbeginings.StoreId=stores.id INNER JOIN fiscalyear ON dsbeginings.FiscalYear=fiscalyear.FiscalYear WHERE dsbeginings.FiscalYear='.$fy.' AND dsbeginings.StoreId IN (SELECT storeassignments.StoreId FROM storeassignments WHERE storeassignments.UserId="'.$userid.'" AND storeassignments.Type=1) ORDER BY dsbeginings.id DESC');
        if(request()->ajax()) {
            return datatables()->of($req)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                $user=Auth()->user();
                $infobtn='';
                $editbtn='';
                $startcountbtn='';
                $resumecount='';
                $countnoteln='';
                $begnoteln='';
                $adjustln='';
                if($data->Status=='Ready')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn=' <a class="dropdown-item startCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Start Counting</span>  </a>';
                    $infobtn='';
                    $resumecount='';
                    $countnoteln='';
                    $begnoteln='';
                    $adjustln='';
                }
                else if($data->Status=='Counting')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/dsbg/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Done')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn='<a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span>  </a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/dsbg/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Verified')
                {
                    if($user->can('Begining-Edit'))
                    {
                        $editbtn=' <a class="dropdown-item editBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>';
                    }
                    $startcountbtn='';
                    $infobtn='';
                    $resumecount=' <a class="dropdown-item resumeDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-play"></i><span> Resume Counting</span></a>';
                    $begnoteln='';
                    $countnoteln=' <a class="dropdown-item printAttachment" href="javascript:void(0)" data-link="/dsbg/'.$data->id.'" id="printcnote" data-attr="" title="Print Count Note"><i class="fa fa-file"></i><span> Print Count Note</span></a>';
                    $adjustln='';
                }
                else if($data->Status=='Posted')
                {
                    $editbtn='';
                    $startcountbtn='';
                    $infobtn=' <a class="dropdown-item infoDsCounting" data-id="'.$data->id.'" data-fyear="'.$data->FiscalYear.'" data-status="'.$data->Status.'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span>  </a>';
                    $resumecount='';
                    if($user->can('Begining-Adjust'))
                    {
                        $adjustln='  <a class="dropdown-item adjustmentBegining" href="javascript:void(0)" data-toggle="modal" data-id="'.$data->id.'" data-status="'.$data->Status.'"  data-sst="'.$data->Store.'" id="dteditbtn" data-original-title="Edit"><i class="fa fa-edit"></i><span> Adjust</span></a>';
                    }
                    $begnoteln=' <a class="dropdown-item printBgAttachment" href="javascript:void(0)" data-link="/dsbgp/'.$data->id.'" id="printbgatt" data-attr="" title="Print Begining Attachment"><i class="fa fa-file"></i><span> Print Attachment</span></a>';
                    $countnoteln=' ';
                  
                }
                $btn='<div class="btn-group dropleft">
                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        '.$infobtn.'
                        '.$editbtn.'
                        '.$startcountbtn.'
                        '.$resumecount.' 
                        '.$adjustln.'
                        '.$begnoteln.'  
                        '.$countnoteln.'   
                    </div>
                </div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
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
