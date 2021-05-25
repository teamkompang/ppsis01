<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecureParam;
use DB;

class Secure_SecureSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:admin_security-list|admin_security-create|admin_security-edit|admin_security-delete', ['only' => ['index','show']]);
        $this->middleware('permission:admin_security-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin_security-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin_security-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $secure_setting = DB::table('parameters')
        ->where('group','=','Security')
        ->distinct()
        ->paginate(5);

        return view('security.secure_setting.index',compact('secure_setting'))
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
        // view list in the form
        $secureparam = DB::table('parameters')
        ->where('id', '=', $id)
        ->distinct()
        ->find($id);

        return view('security.secure_setting.edit',compact('secureparam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SecureParam $secureparam, $id)
    {
        // dd($request);
        $request->validate([
            'group' => 'required',
            'param_value' => 'required',
            'value_details' => 'required',
            'description' => 'required',
            'user_lastmaintain' => 'required',
        ]);

        
        // $params = DB::table('parameters')
        // ->where('id', '=', $id)
        // ->find($id);
        $secureparam = SecureParam::find($id);
        $secureparam->id=$id;
        $secureparam->group = $request->group;
        $secureparam->param_value = $request->param_value;
        $secureparam->value_details = $request->value_details;
        $secureparam->description = $request->description;
        $secureparam->user_lastmaintain = $request->user_lastmaintain;

        // $params->update($request->all());
        // $secureparam->save();

        $secureparam->update([
            'id' => $request->id,
            'group' => $request->group,
            'param_value' => $request->param_value,
            'value_details' => $request->value_details,
            'description' => $request->description,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        return redirect()->route('securesetting.index')
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
