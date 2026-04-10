<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regitem;
use App\Models\setting;
use App\Models\Sales;
use App\CustomClass\barcode_generator;

//use App\Models\barcode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Validation\Rule;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\itemimage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Nexmo\Laravel\Facade\Nexmo;
//use Response;
use Picqer;
use Image;
use PDF;
Use Exception;
use Barcode;

class ItemController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      
        $setings=DB::table('settings')->latest()->first();
        //$skunumbers::Regitem::latest();
        $category=DB::select('select * from categories where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $uom=DB::select('select * from uoms where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $taxtypes=DB::select('select * from taxtype');

        $lastsku = DB::table('regitems')->latest()->first();
       
        return view('registry.item',['category'=>$category,'uom'=>$uom,'taxtypes'=>$taxtypes,'lastsku'=>$lastsku,'setings'=>$setings]);
    }

    public function showItemData()
    {
        $item=DB::select('SELECT regitems.id,regitems.Type,regitems.Name,regitems.itemGroup,regitems.Code,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.MinimumStock,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId=regitems.id) AS Balance,(SELECT IFNULL(SUM(salesitems.ConvertedQuantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id LEFT JOIN uoms on regitems.MeasurementId=uoms.id where regitems.IsDeleted=1 ORDER BY id DESC');
        return datatables()->of($item)->toJson();
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

    public function printbarcodes($id)
    {
    

  //  if(Sales::where('id',$id)->exists())
  //  {
     $bacode=Regitem::find($id);
     $bn=$bacode->BarcodeImage;
    $sale=Sales::find($id);

   
 $data=['sale'=>$sale,'bacode'=>$bacode];
 $pdf=PDF::loadView('registry.invoice',$data);

   //view()->share('registry.invoice',$data);
  return view('registry.invoice',['sale'=>$sale,'bacode'=>$bacode]);

  //return $pdf->stream();
  // }

 


    }

    public function printbar()
    {
       return view('registry.barcode');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
      
      $number=null;
      $barcode=null;
      $image=null;
      $ty=null;
      $message='';
           $type=$request->TypeId; 
           
           if($type=='Goods'||$type=='Consumption')
           {
             $ty='Goods';
             
             $validator = Validator::make($request->all(), [
              'TypeId'=>"required",
              'item_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              'name' =>"required|max:255|min:2|unique:regitems,Name,$request->id",
              'code'=>"required|max:255|min:2|unique:regitems,Code,$request->id",
              'Category'=>"required",
              'Uom'=>"required",
              'wholeSellerPrice'=>'not_in:0',
              'wholeSellerMinAmount'=>"not_in:0",
              
              
              'skuNumber'=>"required_if:TypeId,Goods|unique:regitems,SKUNumber,$request->id",

             // 'wholeSellerMinAmount'=>"required_unless:wholeSellerPrice,0,1",
             
                ]);
                $validator->sometimes('wholeSellerMinAmount', 'required', function ($input) {
                  return $input->wholeSellerPrice > 0;
              });

           }
           if($type=='Service')
           {
            $validator = Validator::make($request->all(), [
              'TypeId'=>"required",
              'item_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              'name' =>"required|max:255|min:2|unique:regitems,Name,$request->id",
              'code'=>"required|max:255|min:2|unique:regitems,Code,$request->id",
              'Category'=>"required",
              'Uom'=>"required",
              'skuNumber'=>'required_if:TypeId,Goods'
             
                ]);

           }
        
              if ($validator->passes()) {
               $item=new Regitem;
                $number=$request->skuNumber;
                if(!empty($number))
                {
                 
                  if($request->BarcodeTypes=='Generate')
                  {
                  include(app_path().'/CustomClass/barcode.php');
                
                   $barcode_images = new Barcode($number, 4);
                   $barcode_image=$barcode_images->image();
                   $barcode=Image::make($barcode_image);
                  Response::make($barcode->encode('jpeg'));     
                  }
                  // else
                  // {
                  //  $barcode=$number;
                  // }
                  }
                  if(empty($number))
                  {
                    $number=null;
                    $barcode=null;
                  }

                if($request->hasfile('item_image'))
                {
                    $image_file = $request->item_image;
                  $image = Image::make($image_file);
                  Response::make($image->encode('jpeg'));
                  session(["item_image_file"=>$image]);
                  
                }


                if($request->TypeId=='Service')
                {
                 // return response()->json(['type'=>'service is se;ected']);
                 $barcode=null;
                 $image=null;
                 session(["item_image_file"=>null]);
                }

                 if($request->BarcodeTypes=='Generate')
                 {
                   $num=$request->skupdate;
                   $num+=1;

                   $updn=DB::select('UPDATE settings SET skunumber=skunumber+1 WHERE 1');
                 }
                 if(session("item_image_file"))
                 {
                   $image=session("item_image_file");
                 }

                try
                {
                  $sale=Regitem::updateOrCreate(['id' =>$request->id], [
                    'Name' => trim($request->name),
                    'Code' => trim($request->code),
                    'MeasurementId' =>trim($request->Uom),
                    'CategoryId' => trim($request->Category),
                    'RetailerPrice' => $request->retailPrice,
                    'WholesellerPrice' => $request->wholeSellerPrice,
                    'wholeSellerMinAmount' => $request->wholeSellerMinAmount,
                    'MinimumStock' => $request->minimumstock,
                    'RequireSerialNumber' => trim($request->ReqSerialNumber),
                    'TaxTypeId' => trim($request->TaxType),
                    'RequireExpireDate' => trim($request->ReqExpireDate),
                    'PartNumber' => trim($request->partNumber),
                    'Description' => trim($request->description),
                    'BarcodeType' => trim($request->BarcodeTypes),
                    'ActiveStatus' => trim($request->status),
                    'Type' => trim($request->TypeId),
                    'itemGroup' => trim($request->group),
                    'LowStock' => trim($request->lowStock),
                    'IsDeleted' => '1',
                   'itemImage' => $image,
                    'BarcodeImage' => $barcode,
                    'SKUNumber' => $number,
                    'MaxCost'=>$request->maxcosti,
  
                    ]);
                    
                    session(["item_image_file"=>null]);
                    $late=Regitem::where('SKUNumber',$number)->get('id');
                    
                    if($request->id!=null)
                    {
                       // hidden values
                       $updatemaxcost=$request->notifiablemaxcostid;
                       $updateretailprice=$request->notifiablereailerpriceid;
                       $updatewholesellprice=$request->notifiablewholesellerpriceid;
                       // original content
                       $maxost=$request->maxcost;
                       $retailprice=$request->retailPrice;
                       $wholesaleprice=$request->wholeSellerPrice;
                       $itemcode=trim($request->code);

                        if($updatemaxcost!=$maxost)
                        {
    
                          $users2= User::Permission(['Max-cost'])->get();
                          $url='/items';
                          $itemname=$request->name;
                          $username=Auth()->user()->username;
                          $messages='MaxCost Updated from '.$updatemaxcost.' to '.$maxost.' for '.$itemname.'('.$itemcode.') item';

                              try { 
                            Notification::send($users2, new RealTimeNotification($username,$messages,$url));
                            
                            
                          } catch(\Exception $e){
        
                         }
                        }
                        if($updateretailprice!=$retailprice)
                        {
                          
                          $users2= User::Permission(['Item-View'])->get();
                          $url='/items';
                          $itemname=$request->name;
                          $username=Auth()->user()->username;
                          $messages='Retail Price Updated from '.$updateretailprice.' to '.$retailprice.' for '.$itemname.'('.$itemcode.') item';
                              try { 
                            Notification::send($users2, new RealTimeNotification($username,$messages,$url));
                           } catch(\Exception $e){
        
                         }
                        }
                        if($updatewholesellprice!=$wholesaleprice)
                        {
                          
                          $users2= User::Permission(['Item-View'])->get();
                          $url='/items';
                          $itemname=$request->name;
                          $username=Auth()->user()->username;
                          $messages='Wholesale Price Updated from '.$updatewholesellprice.' to '.$wholesaleprice.' for '.$itemname.'('.$itemcode.') item';
                              try { 
                            Notification::send($users2, new RealTimeNotification($username,$messages,$url));
                           } catch(\Exception $e){
        
                         }
                        }
                    }                  
                   return Response::json([
                     'success' => '1',
                     'latest'=>$late,
                                        
                     ]
                  );
                }
                catch(Exception $e)
                {             
                   return Response::json(['dberrors' =>  $e->getMessage()]);
                }


               
            }

            

            return Response::json(['errors' => $validator->errors()]);    
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function geteset()
    {
      return "ok geseted";
    }

    public function show($id)
    {
        $item=DB::select('SELECT regitems.id,regitems.Name,regitems.Code,uoms.Name as uom_name,categories.Name as category_name,regitems.MeasurementId,regitems.CategoryId,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.pmretail,regitems.pmwholesale,regitems.wholeSellerMaxAmount,regitems.MinimumStock,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.path,regitems.imageName,regitems.LowStock,regitems.itemGroup,regitems.Description,regitems.SKUNumber,regitems.oldSKUNumber,regitems.BarcodeType,regitems.oldBarcodeType,regitems.Type,regitems.ActiveStatus,regitems.MaxCost,regitems.minCost,regitems.DeadStockPrice,regitems.averageCost,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId='.$id.') AS AvailableQuantity,(SELECT IFNULL(SUM(salesitems.Quantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id LEFT JOIN uoms on regitems.MeasurementId=uoms.id WHERE regitems.id='.$id);
        $exist= $images=itemimage::where('regitem_id',$id)->exists();
            switch ($exist) {
              case True:
                $itemimage=itemimage::where('regitem_id',$id)->orderby('id','DESC')->get(['imagename']);
                $success=1;
                break;
              
              default:
              $success=0;
              $itemimage='';
                break;
            }
        return Response::json([
        'success'=>$success,
        'item'=>$item,
        'itemimage' => $itemimage,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $item=DB::select('SELECT id,Name,Code,MeasurementId,CategoryId,RetailerPrice,WholesellerPrice,wholeSellerMinAmount,MinimumStock,TaxTypeId,RequireSerialNumber,RequireExpireDate,PartNumber,LowStock,itemGroup,Description,SKUNumber,BarcodeType,Type,ActiveStatus,MaxCost,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) AS Balance from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId='.$id.') AS AvailableQuantity FROM regitems WHERE id='.$id);
      return response()->json($item);
      
    }
    public function getsknumber()
    {
      $setings=DB::table('settings')->latest()->first();
      $numberPadding=sprintf("%06d", $setings->skunumber);
     $sknumber=$setings->prefix.$numberPadding;
     // $sknumber=$numberPadding.$setings->prefix;
     include(app_path().'/CustomClass/barcode.php');
     $barcode_images = new Barcode($sknumber, 4);
     $sk=$barcode_images->checksum($sknumber);

      return response()->json([

         'setting'=>$setings, 
         'numberpaddging'=>$numberPadding, 
         'padded'=>$sk,
       ]);


    }
    public function getgeneratebarcode()
    {



      $setings=DB::table('settings')->latest()->first();

     $numberPadding=sprintf("%06d", $setings->skunumber);
    // $numberPadding='111'.$setings->skunumber;
     $sknumber=$setings->prefix.$numberPadding;
               //$barcode_image=$this->ean13_barcode("$sknumber"); 
               include(app_path().'/CustomClass/barcode.php');
             $barcode_images = new Barcode($sknumber, 4);
           $barcode_image=$barcode_images->image();



             // $barcode_image=display($barcode_images->image());
                // include(app_path().'/CustomClass/barcode.php');
                // $generator=new barcode_generator();
                // $options=array();
                // $barcode_image=$generator->output_image('png','ean-13',$sknumber,$options);

                  $barcodegen=Image::make($barcode_image);
                  $responsegen=Response::make($barcodegen->encode('jpeg'));  
                  $responsegen->header('Content-Type', 'image/jpeg');

                  $setings=DB::table('settings')->latest()->first();
                  return response()->json([
     
                    'generated_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($barcodegen)).'"  />',
                     'setting'=>$setings,    
                   ]);
                  

    }

public function getbarcode($id)
{
$item=Regitem::findOrFail($id);
if($item==NUll)
{
  return 'no selectes item';
}
else
{
  if($item->BarcodeImage!=null)
  {

    $barcode_file = Image::make($item->BarcodeImage);
    $responsebar = Response::make($barcode_file->encode('jpeg'));
    
    $responsebar->header('Content-Type', 'image/jpeg');
    
    return response()->json([
     
      'uploaded_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($item->BarcodeImage)).'"  />',
           
     ]);
  }
  else 
  {
    return response()->json([
      'uploaded_barcodeimage'   => 'Barcode Not Found',
     ]);

  }
}

}

    public function getimage($id)
    {
      $item=Regitem::findOrFail($id);
      if($item==NULL)
      {
        return "def";
      }
      else{
        if($item->itemImage!=null)
        {
          $image_file = Image::make($item->itemImage);
          $response = Response::make($image_file->encode('jpeg'));
          session(["item_image_file"=>$image_file]);
          $response->header('Content-Type', 'image/jpeg');
  
  
          // $barcode_file=Image::make($item->BarcodeImage);
          // $barresponse=Response::make($barcode_file->encode('jpeg'));
          // $barresponse->header('Content-Type', 'image/jpeg');

          return response()->json([
            'message'   => 'Image Upload Successfully',
            'uploaded_image' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($item->itemImage)).'"  />',
           // 'uploaded_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($item->BarcodeImage)).'"  />',
            'class_name'  => 'alert-success'
           ]);

        }
        else
        {
            session(["item_image_file"=>null]);
          return response()->json([
            'uploaded_image'   => 'Image Not Found',
          
           ]);
           
        }
       


        // {{-- <img src="data:image/png;base64,{{ chunk_split(base64_encode($lastsku->itemImage)) }}" height="100" width="100"> --}}
       // return $response;
      }
    


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

    public function delete($id)
    {
      try{
        
        $item = Regitem::FindorFail($id);
        $item->delete();
        return Response::json(['success' => 'Item Record Deleted success fully']);
      }
      catch(Exception $e)
      {
        return Response::json(['deleteErrors' => $e->getMessage()]);
      }
    }
    

                  public  function ean_checkdigit($code){
                  //  $font = "FreeSansBold.ttf";
                    $code = str_pad($code, 12, "0", STR_PAD_LEFT);
                    $sum = 0;
                    for($i=(strlen($code)-1);$i>=0;$i--){
                      $sum += (($i % 2) * 2 + 1 ) * $code[$i];
                     
                    }
                    //$bn=(10 - ($sum % 10));
                    //echo $bn;
                    return (10 - ($sum % 10));
                  }


                  public  function encode_ean13($ean){

                    //$font = "FreeSansBold.ttf";
                    //$font_loc=dirname(__FILE__)."/"."FreeSansBold.ttf";
                    $font = public_path("app-assets/fonts/FreeSansBold.ttf");
                    
                    $digits=array(3211,2221,2122,1411,1132,1231,1114,1312,1213,3112);
                    $mirror=array("000000","001011","001101","001110","010011","011001","011100","010101","010110","011010");
                    $guards=array("9a1a","1a1a1","a1a");
                  
                    $ean=trim($ean);
                    if (preg_match("#[^0-9]#i",$ean)){
                      //die("Invalid EAN-Code");
                      return Response::json(['sknumberInvalid' => 'Invalid EAN-Code']);
                    }
                  
                    if (strlen($ean)<12 || strlen($ean)>13){
                      // die("Invalid EAN13 Code (must have 12/13 numbers)");
                      return Response::json(['sknumberError' => 'Invalid EAN13 Code must have 12/13 numbers']);
                    }
                  
                    $ean=substr($ean,0,12);
                    $eansum=$this->ean_checkdigit($ean);
                    $ean.=$eansum;
                    $line=$guards[0];
                    for ($i=1;$i<13;$i++){
                      $str=$digits[$ean[$i]];
                      if ($i<7 && $mirror[$ean[0]][$i-1]==1) $line.=strrev($str); else $line.=$str;
                      if ($i==6) $line.=$guards[1];
                    }
                    $line.=$guards[2];
                  
                    /* create text */
                    $pos=0;
                    $text="";
                    for ($a=0;$a<13;$a++){
                      if ($a>0) $text.=" ";
                      $text.="$pos:12:{$ean[$a]}";
                      if ($a==0) $pos+=12;
                      else if ($a==6) $pos+=12;
                      else $pos+=7;
                    }
                  
                    $datas=["bars" => $line,	"text" => $text];
                      return $datas;
                  }

                  public  function ean13_barcode($code, $scale = 1, $height = 0)
                  {
                    //$font = "FreeSansBold.ttf";
                    $font = public_path("app-assets/fonts/FreeSansBold.ttf");
                   
                    $ean=$this->encode_ean13($code);
  
                    //foreach($ean as $ean)
                    
                      $bars=$ean['bars'];
                      $text=$ean['text'];
                    $bar_color=Array(0,0,0);
                    $bg_color=Array(255,255,255);
                    $text_color=Array(0,0,0);
                  
                    /* set defaults */
                    if ($scale<1) $scale=2;
                    $height=(int)($height);
                    if ($height<1) $height=(int)$scale * 60;
                  
                    $space=array('top'=>2*$scale,'bottom'=>2*$scale,'left'=>2*$scale,'right'=>2*$scale);
                    
                    /* count total width */
                    $xpos=0;
                    $width=true;
                    for ($i=0;$i<strlen($bars);$i++){
                      $val=strtolower($bars[$i]);
                      if ($width){
                          $xpos+=$val*$scale;
                          $width=false;
                          continue;
                      }
                      if (preg_match("#[a-z]#", $val)){
                          /* tall bar */
                          $val=ord($val)-ord('a')+1;
                      } 
                      $xpos+=$val*$scale;
                      $width=true;
                    }
                  
                    /* allocate the image */
                    $total_x=( $xpos )+$space['right']+$space['right'];
                    $xpos=$space['left'];
                    if (!function_exists("imagecreate")){
                    // return "Please ask your site admin to install php_gd2 extention";
                      return Response::json(['ImageError' => 'Please ask your site admin to install php_gd2 extention']);
                      
                    }
                    $im=imagecreate($total_x, $height);
                    /* create two images */
                    $col_bg=ImageColorAllocate($im,$bg_color[0],$bg_color[1],$bg_color[2]);
                    $col_bar=ImageColorAllocate($im,$bar_color[0],$bar_color[1],$bar_color[2]);
                    $col_text=ImageColorAllocate($im,$text_color[0],$text_color[1],$text_color[2]);
                    $height1=round($height-($scale*10));
                    $height12=round($height-$space['bottom']);
                  
                  
                    /* paint the bars */
                    $width=true;
                    for ($i=0;$i<strlen($bars);$i++){
                      $val=strtolower($bars[$i]);
                      if ($width){
                        $xpos+=$val*$scale;
                        $width=false;
                        continue;
                      }
                      if (preg_match("#[a-z]#", $val)){
                        /* tall bar */
                        $val=ord($val)-ord('a')+1;
                        $h=$height12;
                      } else $h=$height1;
                      imagefilledrectangle($im, $xpos, $space['top'], $xpos+($val*$scale)-1, $h, $col_bar);
                      $xpos+=$val*$scale;
                      $width=true;
                    }
                    /* write out the text */
                    global $_SERVER;
                    $chars=explode(" ", $text);
                    reset($chars);
                   // while (list($n, $v)=each($chars)){
                    foreach($chars as $n => $v) {
                      if (trim($v)){
                          $inf=explode(":", $v);
                          $fontsize=$scale*($inf[1]/1.8);
                          $fontheight1=$height-($fontsize/2.7)+2;
                          @imagettftext($im, $fontsize, 0, $space['left']+($scale*$inf[0])+2,
                          $fontheight1, $col_text, $font, $inf[2]);
                      }
                    }
                  //  }
                  
                      /* output the image */
                    header("Content-Type: image/png; name=\"barcode.png\"");
                   // return imagepng($im);
                   return $im;
                  
                  }

   
}

