<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\SecureParam;
use DB;
use App\pre_reg;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        // dd($request);
        $paramater1 = DB::table('parameters')->select('value_details')->where('param_value', '=', 'passowrd_length')->first();

        $paramater2 = DB::table('parameters')->select('description')
        ->where('param_value', '=', 'Uppercase')
        ->where('value_details', '=', 'True')->first();

        $paramater3 = DB::table('parameters')->select('description')
        ->where('param_value', '=', 'Lowercase')
        ->where('value_details', '=', 'True')->first();

        $paramater4 = DB::table('parameters')->select('description')
        ->where('param_value', '=', 'Specialcharacter')
        ->where('value_details', '=', 'True')->first();

        $paramater5 = DB::table('parameters')->select('description')
        ->where('param_value', '=', 'Number')
        ->where('value_details', '=', 'True')->first();
        // dd($paramater2);
        if(! $paramater2){
            $paramater2 = null;
        }else{
            $paramater2 = $paramater2->description;      
        }if(! $paramater3){
            $paramater3 = null;
        }else{
            $paramater3 = $paramater3->description;      
        }if(! $paramater4){
            $paramater4 = null;
        }else{
            $paramater4 = $paramater4->description;      
        }if(! $paramater5){
            $paramater5 = null;
        }else{
            $paramater5 = $paramater5->description;      
        }

        $data = request()->validate([ 
            'username' => ['required', 'string', 'max:255'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'],
            'password' => ['required', 'confirmed',
                        'string' ,
                        'min:'.$paramater1->value_details, 
                        'regex:/^'.
                        $paramater2.
                        $paramater3.
                        $paramater4.
                        $paramater5.'/'],
            'company' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'received_email' => ['required', 'string', 'max:255'],
            'access_expired' => ['required', 'string', 'max:255'],
            'user_lastmaintain' => ['required', 'string', 'max:255'],
        ]);

        $user = pre_reg::create([
            'email' => $data['email'],
            'company' =>  $data['company'],
            'role' =>  $data['role'],
            'status' =>  $data['status'],
            'received_email' =>  $data['received_email'],
            'access_expired' =>  $data['access_expired'],
            // 'user_lastmaintain' => $data['user_lastmaintain'],
        ]);

        // $user = User::create($request->all());
        $user = User::create([
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), 
            'company' =>  $data['company'],
            'contact' =>  $data['contact'],
            'role' =>  $data['role'],
            'status' =>  $data['status'],
            'received_email' =>  $data['received_email'],
            'access_expired' =>  $data['access_expired'],
            'user_lastmaintain' =>  $data['user_lastmaintain'],
        ]);

        // dd($user);

        $user->assignRole( $data['role']);
        $email = $data['email'];

        $deleteinvite = DB::table('invites')
        ->join('users', 'users.email','=','invites.email')
        ->where('invites.email','=', $email)
        ->delete();

        // $this->guard()->logout();

        return view('auth.login')->withSuccess('Successfully registered. Please Verify your account in your email.');
        // return redirect()->route('home')
        // return redirect()->logout()
        //     ->withSuccess('Successfully registered. Please Verify your account in your email.');
        // return redirect()->withSuccess('Successfully registered. Please Verify your account in your email.');
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
