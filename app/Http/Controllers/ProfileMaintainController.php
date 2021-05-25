<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use DB;
use App\ProfileMaintenance;

class ProfileMaintainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:all_profilemaintain-list|all_profilemaintain-create|all_profilemaintain-edit|all_profilemaintain-delete', ['only' => ['index','show']]);
        $this->middleware('permission:all_profilemaintain-create', ['only' => ['create','store']]);
        $this->middleware('permission:all_profilemaintain-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:all_profilemaintain-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
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
    public function edit($user)
    {
        $user = User::find($user);
        // dd($user);
        return view('profilemaintain.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $users , $id)
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

        $this->validate($request, [
            'username' => 'required',
            'fullname' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'user_lastmaintain' => 'required',
            'password' => ['nullable','confirmed',
                            'min:'.$paramater1->value_details, 
                            'regex:/^'.
                            $paramater2.
                            $paramater3.
                            $paramater4.
                            $paramater5.'/'],
        ]);

// dd($request->password);
        $input = $request->all();

        
        if($request->password){
            $input['password'] = $request->password;
        }
        
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }
        
        $users = User::find($id);
        $users->update($input);

        return redirect()->route('profilemaintain.edit',auth()->user()->id)
        ->with('success', 'Details Update successfully.');
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
