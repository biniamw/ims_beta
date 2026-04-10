<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\companyinfo;
use DB;

class ReorderReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $compId="1";
        $compInfo=companyinfo::find($compId);
        if($request->ajax()) {
            return view('inventory.report.reorder',['compInfo'=>$compInfo])->renderSections()['content'];
        }
        else{
            return view('inventory.report.reorder',['compInfo'=>$compInfo]); 
        } 
    }

    public function reorderrep()
    {
        $settingsval = DB::table('settings')->latest()->first();
        $fiscalyr=$settingsval->FiscalYear;
        $query = DB::select("SELECT regitems.id as id,regitems.Code as ItemCode, regitems.Name as ItemName,regitems.SKUNumber AS SKUNumber,categories.Name as Category, uoms.Name as UOM,regitems.LowStock as ReorderPoint,(sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) as AvailableQuantity FROM transactions inner join regitems on transactions.ItemId=regitems.Id inner join categories on regitems.CategoryId=categories.id inner join uoms on regitems.MeasurementId=uoms.id inner join stores on transactions.StoreId=stores.id where transactions.FiscalYear=($fiscalyr) AND transactions.StoreId IN(select id from stores) AND transactions.ItemId IN(select id from regitems) AND (SELECT (SUM(COALESCE(StockIn,0))-SUM(COALESCE(StockOut,0)))FROM transactions WHERE transactions.ItemId=regitems.id)<=COALESCE(regitems.LowStock,0) AND COALESCE(regitems.LowStock,0)>0 group by regitems.Code,regitems.Name,regitems.SKUNumber,categories.Name,uoms.Name,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.id,regitems.LowStock order by regitems.Name asc");
        return datatables()->of($query)->toJson();
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
