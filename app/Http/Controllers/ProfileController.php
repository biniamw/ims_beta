<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Response;
use DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counrtys=DB::select('select Name from country order by Name asc');
        return view('account.profile',['counrtys'=>$counrtys]);

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
    public function userinfoupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'PhoneNumber' => ['nullable','min:10','max:14','regex:/^([0-9\s\-\+\(\)]*)$/'],
            'AlternatePhoneNumber' => ['nullable','min:10','max:14','regex:/^([0-9\s\-\+\(\)]*)$/'],
            'EmailAddress'=>['nullable','regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
        ]);
        if ($validator->passes())
        {
            User::find(auth()->user()->id)->update(['phone'=>$request->PhoneNumber,'AlternatePhone'=>$request->AlternatePhoneNumber,'email'=>$request->EmailAddress,'Nationality'=>$request->Nationality,'Gender'=>$request->Gender,'Address'=>$request->Address]);
            return Response::json(['success' =>'1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function changepasswordefault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentpassword' => ['required', new MatchOldPassword],
            'newpassword' => ['required','min:6',
                                       'regex:/[a-z]/',
                                       'regex:/[A-Z]/',
                                        'regex:/[a-z]/',
                                        'regex:/[0-9]/',
                                        'regex:/[@$!%*#?&]/'
                                ],
            'confirmnewpassword' => ['required','same:newpassword'],
        ]);
        if ($validator->passes())
        {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newpassword),'ChangePass'=>'1']);
            auth()->logout();
            return Response::json(['success' =>'1']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', new MatchOldPassword],
            'newpassword' => ['required','min:6',
                                    'regex:/[a-z]/',
                                    'regex:/[A-Z]/',
                                    'regex:/[a-z]/',
                                    'regex:/[0-9]/',
                                    'regex:/[@$!%*#?&]/'
                                ],
            'confirmnewpassword' => ['required','same:newpassword'],
        ]);
        if ($validator->passes())
        {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newpassword)]);
            return Response::json(['success' =>'1']);
        }
        else
        {      
        return Response::json(['errors' => $validator->errors()]);
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
