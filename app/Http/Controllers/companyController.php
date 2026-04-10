<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class companyController extends Controller
{
    //

    public function index()
    {
        $companyinfo=DB::select('select * from companyinfos where id=1');
        return view('layout.app',['companyinfo'=>$companyinfo]);
    }
}
