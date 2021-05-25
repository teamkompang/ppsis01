<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\User;
use App\Http\Controllers\Controller;

class Secure_UserMaintainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:admin_usermaintain-list|admin_usermaintain-create|admin_usermaintain-edit|admin_usermaintain-delete', ['only' => ['index','show']]);
        $this->middleware('permission:admin_usermaintain-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin_usermaintain-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin_usermaintain-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // view list in the table
        $users = DB::table('users')
        ->join('collaborator','users.company', '=', 'collaborator.ICode')
        ->join('parameters','users.status', '=', 'parameters.param_value')
        ->join('roles','users.role', '=', 'roles.name')
        ->where('parameters.group', '=', 'Status')
        ->select('users.id as id','users.fullname as fullname','users.email as email','collaborator.Name as company','parameters.value_details as value_details', 'roles.name as role')
        ->distinct()
        ->paginate(5);

        // dd($users);

        // list of panels 
        $panelset = DB::table('collaborator')
        ->distinct()
        ->get();

        // list of panels 
        $status = DB::table('parameters')
        ->where('group','=','Status')
        ->distinct()
        ->get();

        // list of emails 
        $emailstat = DB::table('parameters')
        ->where('group','=','soli_status')
        ->distinct()
        ->get();

        // $roles = Role::pluck('name','name')->all();
        $roles = Role::all();
// dd($roles);
        return view('security.usermaintain.index',compact('users','panelset','status','roles','emailstat'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
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
         // view list in the table
         $useredit = DB::table('users')
         ->join('collaborator','users.company', '=', 'collaborator.ICode')
        //  ->join('parameters','users.received_email', '=', 'parameters.value_details')
         ->distinct()
         ->find($id);

        //  dd($useredit);

         // list of panels 
        $panelset = DB::table('collaborator')
        ->distinct()
        ->get();

        // list of panels 
        $status = DB::table('parameters')
        ->where('group','=','Status')
        ->distinct()
        ->get();

        // list of roles 
        $roles = DB::table('roles')
        ->distinct()
        ->get();

        // list of emails 
        $emailstat = DB::table('parameters')
        ->where('group','=','soli_status')
        ->distinct()
        ->get();

        // dd($emailstat);
        $roling = Role::pluck('name','name','id')->all();
 
         return view('security.usermaintain.edit',compact('useredit','panelset','status','roles','roling','emailstat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $users, $id)
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

        $request->validate([
            'fullname' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'company' => 'required',
            'role' => 'required',
            // 'received_email' => 'received_email',
            'user_lastmaintain' => 'required',
            'password' => ['nullable','confirmed',
                            'min:'.$paramater1->value_details, 
                            'regex:/^'.
                            $paramater2.
                            $paramater3.
                            $paramater4.
                            $paramater5.'/'],
        ]);

        
        // $params = DB::table('parameters')
        // ->where('id', '=', $id)
        // ->find($id);
        if(!empty($request['password'])){
            $request['password'] = Hash::make($request['password']);
        }else{
            $request = array_except($request,array('password'));
        }

        $usermaintain = User::find($id);
        $usermaintain->id=$id;
        $usermaintain->fullname = $request->fullname;
        $usermaintain->email = $request->email;
        $usermaintain->contact = $request->contact;
        $usermaintain->company = $request->company;
        $usermaintain->role = $request->role;
        $usermaintain->received_email = $request->received_email;
        $usermaintain->access_expired = $request->access_expired;
        $usermaintain->status = $request->status;
        $usermaintain->user_lastmaintain = $request->user_lastmaintain;
        if($request->password){
            $usermaintain->password = $request->password;
        }
        

        // $params->update($request->all());
        $usermaintain->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $usermaintain->assignRole($request->input('role'));

        return redirect()->route('usermaintain.index')
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
        User::find($id)->delete();
        return redirect()->route('usermaintain.index')
        ->with('success','User deleted successfully');
    }
}
