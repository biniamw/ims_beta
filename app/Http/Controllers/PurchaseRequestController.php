<?php

namespace App\Http\Controllers;

use App\Models\{purchaseRequest,department,User,Regitem,Commudity,purchaseDetails,setting,uom,store,companyinfo,praction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
                $userid=Auth()->user()->id;
                $user=User::where('id','>',1)->orderby('FullName','asc')->get();
                $item=Regitem::where('id','>',1)->orderby('Code','asc')->get();
                $uom=uom::orderby('Name','asc')->get();
                $commudity=Commudity::orderByDesc('Name')->get();
                $percent=setting::where('id',1)->first()->contingency;
                $woreda=DB::select('SELECT regions.Rgn_Name,zones.Zone_Name,woredas.Woreda_Name,woredas.id FROM woredas INNER JOIN zones ON woredas.zone_id=zones.id INNER JOIN regions ON zones.Rgn_Id=regions.id');
                $department=department::where('id','>',1)->orderby('DepartmentName','asc')->get();
                $settingsval = DB::table('settings')->latest()->first();
                $fiscalyr=$settingsval->FiscalYear;
                $fiscalyears=DB::select('select * from fiscalyear where fiscalyear.FiscalYear<='.$fiscalyr.' order by fiscalyear.FiscalYear DESC');
                $stores=store::where('id','>',1)->orderby('Name','asc')->get();
                $currentdate = Carbon::today()->toDateString();
                $cropyear=DB::select('SELECT lookups.CropYear FROM lookups WHERE lookups.CropYearStatus="Active" ORDER BY lookups.CropYearValue  DESC');
                return view('pr.purchaserequest',[
                                                'user'=>$user,
                                                'uom'=>$uom,
                                                'department'=>$department,
                                                'commudity'=>$commudity,
                                                'woreda'=>$woreda,
                                                'item'=>$item,
                                                'percent'=>$percent,
                                                'fiscalyears'=>$fiscalyears,
                                                'stores'=>$stores,
                                                'todayDate'=>$currentdate,
                                                'cropyear'=>$cropyear,
                                            ]);
    }
public function checkreview($fiscalyr){
            $budget=setting::where('id',1)->first()->budget;
            $update=purchaseRequest::where([['totalprice','>',$budget],['status',2],['isapproved',0],['fiscalyear',$fiscalyr]])->update(['oldstatus'=>DB::raw('status'),'status'=>4]);
            $reviewsales=purchaseRequest::whereIn('purequests.status',[4,5])->where([['fiscalyear',$fiscalyr],['totalprice','>',$budget]])->count();
            return Response::json(['success' =>200,
            'reviewsales'=>$reviewsales,
        ]);
    }

        public function reviewlist($fiscalyear){
            $budget=setting::where('id',1)->first()->budget;
            $purchaserequest=purchaseRequest::join('stores','stores.id','=','purequests.store_id')
                ->join('users','users.id','=','purequests.user_id')
                ->whereIn('purequests.status',[5,6])
                ->where([['purequests.fiscalyear',$fiscalyear],['purequests.totalprice','>',$budget]])
                ->orderBy('purequests.id','DESC')
                ->get(['stores.Name as storename','users.FullName','purequests.id','purequests.docnumber','purequests.type','purequests.date','purequests.source','purequests.currency','purequests.priority','purequests.requiredate','purequests.contingency','purequests.status','purequests.isapproved','purequests.reviewby']);
                return datatables()->of($purchaserequest)->addIndexColumn()->toJson();
    }
    public function undoprpermit($checkid){
        try {
            $currentTime = now();
            $user=Auth()->user()->FullName;
            $checkid=explode(",",$checkid);
            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $reviewby=' Undo Reviewed by '.$user.' on '.$day;
            $update=purchaseRequest::whereIn('id',$checkid)->update(['isapproved'=>2,'reviewby'=>DB::raw("CONCAT(IFNULL(reviewby,''),'$reviewby')"),'oldstatus'=>DB::raw('status'),'status'=>5]);
            foreach($checkid as $key){
                    $praction=new praction();
                    $pr=purchaseRequest::find($key);
                    $praction->action='Undo Review';
                    $praction->user=$user;
                    $praction->time=$day;
                    $pr->puchaseactions()->save($praction);
            }
            return Response::json(['success' => 200,
                                ]);
        } catch (\Throwable $th) {
            return Response::json(['error' => $e->getMessage() ,
                                ]);
        }
    }
    public function prpermit($checkid){
            try {
            $currentTime =now();
            $user=Auth()->user()->FullName;
            $checkid=explode(",",$checkid);
            $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
            $reviewby=' Reviewed by '.$user.' on '.$day;
            $update=purchaseRequest::whereIn('id',$checkid)->update(['isapproved'=>1,'reviewby'=>DB::raw("CONCAT(IFNULL(reviewby,''),'$reviewby')"),'status'=>6]);
                foreach($checkid as $key){
                        $praction=new praction();
                        $pr=purchaseRequest::find($key);
                        $praction->action='Review';
                        $praction->user=$user;
                        $praction->time=$day;
                        $pr->puchaseactions()->save($praction);
                }
            return Response::json(['success' => 200,
                                    ]);
        } catch (Throwable $e) {
            return Response::json(['error' => $e->getMessage() ,
                                    ]);
        }
    }
    public function purchaslist($fiscalyear)
    {
        // $afmembers = afmembers::select("afmembers.id", 
        //             DB::raw("CONCAT(afmembers.firstname,' ',afmembers.middlename,' ',afmembers.lastname) as full_name"),
        //             "afmembers.phone", "afmembers.status","afmembers.amount","afmembers.support","afmembers.total","afmembers.qrcode"
        //         )
        //         ->get();
        $purchaserequest=purchaseRequest::join('stores','stores.id','=','purequests.store_id')
                ->join('users','users.id','=','purequests.user_id')
                ->where('purequests.fiscalyear',$fiscalyear)
                ->orderBy('purequests.id','DESC')
                ->get(['stores.Name as storename','users.FullName','purequests.id','purequests.docnumber','purequests.type','purequests.date','purequests.source','purequests.currency','purequests.priority','purequests.requiredate','purequests.contingency','purequests.status']);
                return datatables()->of($purchaserequest)->addIndexColumn()->toJson();
    }
    public function prattachemnt($id){
        if(purchaseRequest::where('id',$id)->exists()){
            $type=purchaseRequest::where('id',$id)->first()->type;
                switch ($type) {
                    case 'Goods':
                    $pr=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                        ->where('purequest_id',$id)->get(['regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.totalprice','purdetails.remark']);
                        break;
                    default:
                                $pr=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                                    ->join('zones','woredas.zone_id','=','zones.id')
                                                    ->join('regions','zones.Rgn_Id','=','regions.id')
                                                
                                                    ->where('purequest_id',$id)
                                                    ->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as RZW'),
                                                            'purdetails.id as prid','woredas.id','woredas.Woreda_Name as Name','purdetails.proccesstype','purdetails.cropyear',
                                                            'purdetails.grade','purdetails.proccesstype','purdetails.uomamount','purdetails.qty',
                                                            'purdetails.totalkg','purdetails.ton','purdetails.price','purdetails.totalprice','purdetails.feresula',
                                                            'purdetails.remark'
                                                                ]);
                                                                
                            break;
                }
            $totalprice=purchaseRequest::find($id);
            $action=$totalprice->puchaseactions;
            $status=$totalprice->status;
            $preparedby=praction::where([['purequest_id',$id],['action','PR Prepared']])->latest()->first();
            $verifyby=praction::where([['purequest_id',$id],['action','Verify']])->latest()->first();
            $aothorizeby=praction::where([['purequest_id',$id],['action','Authorize']])->latest()->first();
            $reviewby=praction::where([['purequest_id',$id],['action','Reviewed']])->latest()->first();
            $approveby=praction::where([['purequest_id',$id],['action','Approve']])->latest()->first();

            
            //return Response::json(['success' => $reviewby]);
            $store=$totalprice->store_id;
            $withold=$totalprice->withold;
            $storename=store::find($store)->Name;
            $due_date=Carbon::now();
            $compId="1";
            $compInfo=companyinfo::find($compId);
            $percent=setting::where('id',1)->first()->contingency;
            //$user=User::where('id',$totalprice->user_id)->first()->FullName;
            $count=0;
            $totalkg=purchaseDetails::where('purequest_id',$id)->sum('totalkg');
            $totalton=purchaseDetails::where('purequest_id',$id)->sum('ton');
            $totalfersula=purchaseDetails::where('purequest_id',$id)->sum('feresula');
            switch ($withold) {
                case 0.00:
                    $amountinword=$this->convert_number_to_words($totalprice->totalewithcontingency);
                    break;
                default:
                    $amountinword=$this->convert_number_to_words($totalprice->net);
                    break;
            }
            switch ($status) {
                case 4:
                    $watermark='Void';
                    break;
                case 5:
                    $watermark='Review';
                    break;
                    case 7:
                    $watermark='Rejected';
                    break;
                default:
                    $watermark='Purchase Request';
                    break;
            }
            $data=[
                'pr'=>$pr,
                'totalprice'=>$totalprice,
                'count'=>$count,
                'due_date'=>$due_date,
                'compInfo'=>$compInfo,
                'storename'=>$storename,
                'percent'=>$percent,
                'preparedby'=>$preparedby,
                'verifyby'=>$verifyby,
                'aothorizeby'=>$aothorizeby,
                'reviewby'=>$reviewby,
                'approveby'=>$approveby,
                'amountinword'=>$amountinword,
                'totalkg'=>$totalkg,
                'totalton'=>$totalton,
                'totalfersula'=>$totalfersula,
            ];
                $mpdf=new \Mpdf\Mpdf([
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 32,
                    'margin_bottom' => 25,
                    'margin_header' => 10,
                    'margin_footer' => 1
                ]);
            $date = Carbon::now('Africa/Addis_Ababa')->format('Y-m-d @ H:i:s');
            $html=\View::make('pr.attachment')->with($data);
            $html=$html->render();
            $mpdf->SetProtection(array('print'));
            $mpdf->SetTitle("Pr Attachment");
            $mpdf->SetAuthor("Designed By RAK Computer Technology");
            $mpdf->SetWatermarkText($watermark);
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->WriteHTML($html);
            $mpdf->Output('Prattachment.pdf','I');
    }
    else{
        return 'No sales found';
    }
    }
    public static function convert_number_to_words($number) {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
        if ($number < 0) {
            return $negative . Self::convert_number_to_words(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_number_to_words($remainder);
                }
                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
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
        $validator = Validator::make($request->all(), [
            'type' => ['required'],
            
            'date' => ['required','before:now'],
            'coffeesource' =>  ['required_if:type,Commodity'],
            
            'requestStation' => ['required'],
            'requiredate' => ['required'],
            'priority' => ['required'],
            'coffestatus' => ['required_if:type,Commodity'],
            'currency' => ['required'],
            'commoditytype' => ['required_if:type,Commodity'],
            'itemtype' => ['required_if:type,Goods'],
        ]);
            switch ($request->type) {
                case 'Goods':
                    $rules=array(
                        'row.*.ItemId' => 'required',
                        'row.*.Quantity' => 'required|gt:0',
                        'row.*.price' => 'required|gt:0',
                        );
                    break;
                default:
                    $rules=array(
                            'row.*.ItemId' => 'required',
                            'row.*.proccesstype' => 'required',
                            'row.*.cropyear' => 'required',
                            'row.*.grade' => 'required',
                            
                            'row.*.price' => 'required',
                        );
                    break;
            }
            
            $v2= Validator::make($request->all(), $rules);
            if ($validator->passes() && $v2->passes() && ($request->row!=null)) {
                try {
                    $itemdata=[];
                    $lasteditedby='';
                    $preparedby='';
                    $settingsval = DB::table('settings')->latest()->first();
                    $inc=$settingsval->purchaseno+1;
                    $fiscalyr=$settingsval->FiscalYear;
                    $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                    $userby=Auth()->user()->FullName;
                    if($request->documentnumber==null){
                        $year=$fiscalyr-2000;
                        $addyear=$year+1;
                        $docPrefix=$settingsval->purchaseprefix;
                        $docNum=$settingsval->purchaseno;
                        $numberPadding=sprintf("%06d", $docNum);
                        $docNumber=$docPrefix.$numberPadding;
                        $docNumber=$docNumber.'/'.$year.'-'.$addyear;
                        $inc=$settingsval->purchaseno+1;
                        $settingUpdate=setting::where('id',1)->update(['purchaseno'=>$inc]);
                    } else{
                        $docNumber=$request->documentnumber;
                    }
                    if($request->purchaseid!=null){
                        $lasteditedby=$userby.' on '.$day;
                        $preparedby=purchaseRequest::where('id',$request->purchaseid)->first()->preparedby;
                    } else{
                        $preparedby=$userby.' on '.$day;
                    }
                    $praction=new praction();
                    $pr=purchaseRequest::updateOrCreate(['id' =>$request->purchaseid], [
                        'type' => $request->type,
                        'date' =>$request->date,
                        'commudtytype' =>$request->commoditytype,
                        'department_id'=>$request->department,
                        'user_id'=>1,
                        'currency' => $request->currency,
                        'contingency' => $request->contingency,
                        'isorganic' => $request->coffecerificate,
                        'coffestat' => $request->coffestatus,
                        'cropyear' => $request->cropYear,
                        'preparedby' => $preparedby,
                        'lasteditedby' => $lasteditedby,
                        'docnumber' => $docNumber,
                        'fiscalyear' => $fiscalyr,
                        'priority' => $request->priority,
                        'requiredate' => $request->requiredate,
                        'memo' => $request->memo,
                        'store_id' => $request->requestStation,
                        'coffeesource' => $request->coffeesource,
                        'itemtype' => $request->itemtype,
                        'totalprice' => $request->subtotali,
                        'totalewithcontingency' => $request->totalwithcontigencyi,
                        'withold' => $request->witholdi,
                        'contingency' => $request->contigencyi,
                        'net' => $request->netpayi,
                        'tax' => $request->taxi,
                        'istaxable' => $request->istaxable,
                        ]);
                        if ($request->purchaseid!=null) {
                            $prid=$request->purchaseid;
                            $status=purchaseRequest::where('id',$request->purchaseid)->first()->status;
                            switch ($status) {
                                case 0:
                                    $stat='Draft';
                                    break;
                                case 1:
                                    $stat='Pending';
                                    break;
                                    case 2:
                                    $stat='Verify';
                                    break;
                                default:
                                    $stat='--';
                                    break;
                            }
                            $praction->action='PR Edited';
                            $praction->status=$stat;
                            $praction->user=$userby;
                            $praction->time=$day;
                            $pr->puchaseactions()->save($praction);
                        } else{
                            $prid = purchaseRequest::latest()->first()->id;
                            $praction->action='PR Prepared';
                            $praction->status='Draft';
                            $praction->user=$userby;
                            $praction->time=$day;
                            $pr->puchaseactions()->save($praction);
                        }
                        
                    switch ($request->type) {
                        case 'Goods':
                            foreach ($request->row as $key => $value)
                                {
                                    $itemdata[(int)$value['ItemId']] = 
                                    [ 
                                        'qty' =>(int)$value['Quantity'],
                                        'price'=>(float)$value['price'],
                                        'totalprice'=>(float)$value['totalprice'],
                                        'remark'=>$value['remark'],
                                    ];
                                }
                            $pr->items()->sync($itemdata);
                            break;
                        default:
                        
                                if (!empty($request->purchaseid)) {
                                    $cerids=[];
                                    foreach ($request->row as $key => $value){
                                        $cerids[]=(int)$value['prid'];
                                    }
                                    purchaseDetails::where('purequest_id',$request->purchaseid)->whereNotIn('id',$cerids)->delete();
                                }
                                
                            foreach ($request->row as $key => $value){
                                $detailid=(int)$value['prid'];
                                $item=(int)$value['ItemId'];
                                $cropyear=(int)$value['cropyear'];
                                $proccesstype=$value['proccesstype'];
                                $grade=$value['grade'];
                                $totalkg=(float)$value['totalkg'];
                                $ton=(float)$value['ton'];
                                $feresula=(float)$value['feresula'];
                                $price=(float)$value['price'];
                                $totalprice=(float)$value['totalprice'];
                                $remark=$value['remark'];
                                
                                $pedetials=purchaseDetails::updateOrCreate(['id' =>$detailid],[
                                        'purequest_id'=>$prid,
                                        'woreda_id'=>$item,
                                        'cropyear' =>$cropyear,
                                        'proccesstype'=>$proccesstype,
                                        'grade'=>$grade,
                                        'totalkg'=>$totalkg,
                                        'ton'=>$ton,
                                        'feresula'=>$feresula,
                                        'price'=>$price,
                                        'totalprice'=>$totalprice,
                                        'remark'=>$remark
                                ]);
                            }
                            break;
                    }
                    return Response::json(['success' => 200]);
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
            if($v2->fails()){
                            return Response::json(['errorv2' => $v2->errors()->all()]);
                        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\purchaseRequest  $purchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function purchaseaction($id,$status){
        $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
        $userby=Auth()->user()->FullName;
        $actionby=$userby.' on '.$day;
        $praction=new praction();
        $pr=purchaseRequest::find($id);
        switch ($status) {

            case 1:
                $prupdate=purchaseRequest::where('id',$id)->update(['status'=>1,'verifyby'=>$actionby]);
                $praction->action='Change To Pending';
                $praction->status='Pending';
                $praction->user=$userby;
                $praction->time=$day;
                $pr->puchaseactions()->save($praction);
                $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                return Response::json([
                                        'success' => 200,
                                        'message'=>'Successfully verified',
                                        'status'=>1,
                                        'actions'=>$actions,
                                    ]);
                break;
                
                case 2:
                $prupdate=purchaseRequest::where('id',$id)->update(['status'=>2,'aouthorizeby'=>$actionby]);
                $praction->action='Verify';
                $praction->status='Verify';
                $praction->user=$userby;
                $praction->time=$day;
                $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                $pr->puchaseactions()->save($praction);
                return Response::json([
                                        'success' => 200,
                                        'message'=>'Successfully aouthorized',
                                        'status'=>2,
                                        'actions'=>$actions,
                                    ]);
                break;
                case 3:
                $prupdate=purchaseRequest::where('id',$id)->update(['status'=>3,'approveby'=>$actionby]);
                $praction->action='Approve';
                $praction->status='Approve';
                $praction->user=$userby;
                $praction->time=$day;
                $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                $pr->puchaseactions()->save($praction);
                return Response::json([
                                        'success' => 200,
                                        'message'=>'Successfully approved',
                                        'status'=>3,
                                        'actions'=>$actions,
                                    ]);
                break;
                case 5:
                $prupdate=purchaseRequest::where('id',$id)->update(['status'=>5,'approveby'=>$actionby]);
                $praction->action='Reviewed';
                $praction->status='Reviewed';
                $praction->user=$userby;
                $praction->time=$day;
                $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                $pr->puchaseactions()->save($praction);
                return Response::json([
                                        'success' => 200,
                                        'message'=>'Successfully Reviewed',
                                        'status'=>3,
                                        'actions'=>$actions,
                                    ]);
                break;
                case 4:
                    $oldstatus=purchaseRequest::where('id',$id)->first()->oldstatus;
                    $prupdate=purchaseRequest::where('id',$id)->update(['status'=>$oldstatus,'undovoidby'=>$actionby]);
                    switch ($oldstatus) {
                            case 0:
                                $status='pending';
                            break;
                            case 1:
                                $status='Verify';
                            break;
                            case 3:
                                $status='Authorize';
                            break;
                            case 4:
                                $status='Approve';
                            break;
                            case 5:
                                $status='Review';
                            break;
                            case 6:
                                $status='Reviewed';
                            break;
                        default:
                            $status='Rejected';
                            break;
                    }
                    $praction->action='Undo Void';
                    $praction->status=$status;
                    $praction->user=$userby;
                    $praction->time=$day;
                    $pr->puchaseactions()->save($praction);
                    $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                    return Response::json([
                                            'success' => 200,
                                            'message'=>'Successfully undo void',
                                            'status'=>$oldstatus,
                                            'actions'=>$actions,
                                        ]);
                break;
                case 777:
                    $oldstatus=purchaseRequest::where('id',$id)->first()->oldstatus;
                    $prupdate=purchaseRequest::where('id',$id)->update(['status'=>$oldstatus]);
                    switch ($oldstatus) {
                            case 0:
                                $status='pending';
                            break;
                            case 1:
                                $status='Verify';
                            break;
                            case 3:
                                $status='Authorize';
                            break;
                            case 4:
                                $status='Approve';
                            break;
                            case 5:
                                $status='Review';
                            break;
                            case 6:
                                $status='Reviewed';
                            break;
                        default:
                            $status='Rejected';
                            break;
                    }
                    $praction->action='Undo Reject';
                    $praction->status=$status;
                    $praction->user=$userby;
                    $praction->time=$day;
                    $pr->puchaseactions()->save($praction);
                    $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                    return Response::json([
                                            'success' => 200,
                                            'message'=>'Successfully undo void',
                                            'status'=>$oldstatus,
                                            'actions'=>$actions,
                                        ]);
                break;
                case 6:
                $prupdate=purchaseRequest::where('id',$id)->update(['isapproved'=>1,'status'=>6,'reviewby'=>$actionby]);
                $praction->action='Review';
                $praction->status='Review';
                $praction->user=$userby;
                $praction->time=$day;
                $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                $pr->puchaseactions()->save($praction);
                return Response::json([
                                        'success' => 200,
                                        'message'=>'Successfully approved',
                                        'status'=>3,
                                        'actions'=>$actions,
                                    ]);
                break;
                case 8:
                $prupdate=purchaseRequest::where('id',$id)->update(['isapproved'=>2,'status'=>4,'reviewby'=>$actionby]);
                $praction->action='Undo Review';
                $praction->status='Review';
                $praction->user=$userby;
                $praction->time=$day;
                $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
                $pr->puchaseactions()->save($praction);
                return Response::json([
                                        'success' => 200,
                                        'message'=>'Successfully approved',
                                        'status'=>3,
                                        'actions'=>$actions,
                                    ]);
                break;
            default:
                # code...
                break;
        }
    }
    public function purchasevoid(Request $request){
            $validator = Validator::make($request->all(), [
                'Reason' => ['required'],
            ]);
            if ($validator->passes()){
                $day = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->settings(['timezone' => 'Africa/Addis_Ababa'])->format('Y-m-d @ g:i:s A');
                $userby=Auth()->user()->FullName;
                $voidby=$userby.' on '.$day;
                $oldstatus=purchaseRequest::where('id',$request->purchasevoidid)->first()->status;
                $isapproved=purchaseRequest::where('id',$request->purchasevoidid)->first()->isapproved;
                $praction=new praction();
                switch ($request->voidtype) {
                    case 'Void':
                        $ac='Void';
                        $prstatus='Void';
                        $status=6;
                        break;
                    case 'Draft':
                        $ac='Back To Draft';
                        $prstatus='Draft';
                        $status=0;
                    break;  
                    case 'Pending':
                        $ac='Back To Pending';
                        $prstatus='Pending';
                        $status=1;
                        $isapproved=0;
                    break;
                    case 'Verify':
                        $ac='Back To Verify';
                        $prstatus='Verify';
                        $status=2;
                        $isapproved=0;
                        break;
                    default:
                        $ac='Rejected';
                        $prstatus='Rejected';
                        $status=7;
                        break;
                }
                $pr=purchaseRequest::find($request->purchasevoidid);
                try {
                    $pr=purchaseRequest::updateOrCreate(['id' =>$request->purchasevoidid], [
                        'status' =>  $status,
                        'oldstatus' =>$oldstatus,
                        'reason' => $request->Reason,
                        'voidby' => $voidby,
                        'isapproved'=>$isapproved,
                    ]);
                    $praction->action=$ac;
                    $praction->status=$prstatus;
                    $praction->user=$userby;
                    $praction->time=$day;
                    $praction->reason=$request->Reason;
                    $pr->puchaseactions()->save($praction);
                return Response::json(['success' => 200]);
                } catch (\Throwable $th) {
                    return Response::json(['dberrors' =>  $th->getMessage()]);
                }
            }
            if($validator->fails()){
                return Response::json(['errors' => $validator->errors()]);
            }
    }
    
    public function predit($id){
        $type=purchaseRequest::where('id',$id)->first()->type;
        //$pr=purchaseRequest::where('id',$id)->get();
        switch ($type) {
            case 'Goods':
                $pr=purchaseRequest::withCount('items as totalitems')->where('id',$id)->get();
                $productlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
                    ->where('purequest_id',$id)->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.remark']);
                break;
            default:
                    $pr=purchaseRequest::withCount('commuidities as totalitems')->where('id',$id)->get();
                    $productlist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
                                                    ->join('zones','woredas.zone_id','=','zones.id')
                                                    ->join('regions','zones.Rgn_Id','=','regions.id')
                                                    ->where('purequest_id',$id)
                                                    ->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as RZW'),
                                                            'purdetails.id as prid','woredas.id','woredas.Woreda_Name as Name','purdetails.proccesstype','purdetails.cropyear',
                                                            'purdetails.grade','purdetails.proccesstype','purdetails.qty','purdetails.totalkg','purdetails.ton','purdetails.price',
                                                            'purdetails.totalprice','purdetails.feresula','purdetails.remark'
                                                                ]);
            break;
        }
        return Response::json([
                                'success' =>200,
                                'pr'=>$pr,
                                'productlist'=>$productlist,
                            ]);
    }
    public function prinfo($id){
        $type=purchaseRequest::where('id',$id)->first()->type;
        $store=purchaseRequest::where('id',$id)->first()->store_id;
        $user=purchaseRequest::where('id',$id)->first()->user_id;
        $storename=store::where('id',$store)->first()->Name;
        $emploaye=User::where('id',$user)->first()->FullName;
        $actions = purchaseRequest::find($id)->puchaseactions()->orderby('id','desc')->get();
        switch ($type) {
            case 'Goods':
                $pr=purchaseRequest::with('items:id,Name','users:FullName','departments:DepartmentName')->withCount('items as totalitems')->where('id',$id)->get();
                break;
            
            default:
                $pr=purchaseRequest::with('commuidities:id,Name','users:FullName','departments:DepartmentName')->withCount('commuidities as totalitems')->where('id',$id)->get();
                break;
        }
        
        return Response::json([
                                'success' =>200,
                                'pr'=>$pr,
                                'storename'=>$storename,
                                'emploaye'=>$emploaye,
                                'actions'=>$actions,
                            ]);
    }

    public function purchaseinfoitemlist($id){
        $itemlist=purchaseDetails::join('regitems','regitems.id','=','purdetails.regitem_id')
        ->where('purequest_id',$id)->get(['regitems.Code','regitems.Name','regitems.SKUNumber','purdetails.qty','purdetails.price','purdetails.totalprice','purdetails.remark']);
        return datatables()->of($itemlist)->addIndexColumn()->toJson();
    }
    public function purchaseinfocomoditylist($id){
        $comiditylist=purchaseDetails::join('woredas','woredas.id','=','purdetails.woreda_id')
            ->join('zones','woredas.zone_id','=','zones.id')
            ->join('regions','zones.Rgn_Id','=','regions.id')
            ->where('purequest_id',$id)->get([DB::raw('CONCAT(regions.Rgn_Name," ",zones.Zone_Name," ",woredas.Woreda_Name) as RZW'),
                                                        'purdetails.proccesstype','purdetails.cropyear','purdetails.grade','purdetails.qty','purdetails.totalkg',
                                                        'purdetails.ton','purdetails.price','purdetails.totalprice','purdetails.feresula','purdetails.status',
                                                        'purdetails.qty','purdetails.remark'
                                                    ]);
            return datatables()->of($comiditylist)->addIndexColumn()->toJson();
    }
    public function show(purchaseRequest $purchaseRequest)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\purchaseRequest  $purchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(purchaseRequest $purchaseRequest)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\purchaseRequest  $purchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, purchaseRequest $purchaseRequest)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\purchaseRequest  $purchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(purchaseRequest $purchaseRequest)
    {
        
    }
}