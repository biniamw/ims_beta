<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportData;
use App\Imports\ImportUom;
use App\Imports\ImportItem;
use App\Imports\ImportCustomer;
use App\Imports\ImportStore;
use App\Imports\ImportBeginning;
use App\Models\Category;
use Response;

class ImportDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         //return view('setting.import');
        if($request->ajax()) {
            return view('setting.import')->renderSections()['content'];
        }
        else{
            return view('setting.import');
        }
    }

    public function import(Request $request){
        $docty=$request->doctype;
        if($docty==1){
            try{
                Excel::import(new ImportData,$request->file('excel_file')->store('excel_file'));
                return Response::json(['success' =>'1']);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['imperror' =>$datarow]);
            }
        }
        if($docty==2){
            try{
                Excel::import(new ImportUom,$request->file('excel_file')->store('excel_file'));
                return Response::json(['success' =>'1']);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['imperror' =>$datarow]);
            }
        }
        if($docty==3){
            try{
                Excel::import(new ImportItem,$request->file('excel_file')->store('excel_file'));
                return Response::json(['success' =>'1']);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['imperror' =>$datarow]);
            }
        }
        if($docty==4){
            try{
                Excel::import(new ImportCustomer,$request->file('excel_file')->store('excel_file'));
                return Response::json(['success' =>'1']);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['imperror' =>$datarow]);
            }
        }
        if($docty==5){
            try{
                Excel::import(new ImportStore,$request->file('excel_file')->store('excel_file'));
                return Response::json(['success' =>'1']);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['imperror' =>$datarow]);
            }
        }
        if($docty==6){
            try{
                Excel::import(new ImportBeginning,$request->file('excel_file')->store('excel_file'));
                return Response::json(['success' =>'1']);
            }
            catch (\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures();
                $data=[];
                $datarow=[];
                $string="";
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                    $datarow[]="Row # : ".$failure->row()."<br> Error : ".implode(",",$failure->errors())."<br>";
                    $data[]="";
                }
                return Response::json(['imperror' =>$datarow]);
            }
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
        //
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
