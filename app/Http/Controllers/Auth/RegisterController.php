<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\SecureParam;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
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

        return Validator::make($data, [
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
            'user_lastmaintain' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), 
            'company' =>  $data['company'],
            'contact' =>  $data['contact'],
            'role' =>  $data['role'],
            'status' =>  $data['status'],
            'user_lastmaintain' =>  $data['user_lastmaintain'],
        ]);

        $user->assignRole( $data['role']);
    }

    
}
