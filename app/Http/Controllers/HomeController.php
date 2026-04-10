<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=Auth()->user();
        $changepass=$user->ChangePass;
        $status=$user->Status;
        $companyinfo=DB::select('select * from companyinfos where id=1');
        
        foreach($companyinfo as $companyinfo)
        {
            $companyName=$companyinfo->Name;
            session(['companyName'=>$companyName]);
        }

        if($changepass=='0')
        {
            return view('account.changepassword');
        }

        else if($status=='Inactive')
        {
            $deactivemessage="These Account is Deactivated";
            session(['deactiveMessage'=>$deactivemessage]);
            auth()->logout();
            return view('auth.login');
        }

        else
        {
            return view('ims');
        }
    }

    public function getCurrentDate()
    {
        $curdate=Carbon::today()->toDateString();
        return response()->json(['curdate'=>$curdate]); 
    }



}
