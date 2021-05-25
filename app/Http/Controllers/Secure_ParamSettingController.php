<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecureParam;
use App\Parameter_Category;
use App\User;
use DB;

class Secure_ParamSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:admin_parameter-list|admin_parameter-create|admin_parameter-edit|admin_parameter-delete', ['only' => ['index','show']]);
        $this->middleware('permission:admin_parameter-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin_parameter-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin_parameter-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $secure_param = DB::table('parameters')
        ->where('group','<>','Security')
        ->distinct()
        ->paginate(5);

        $groupparam = DB::table('param_category')
        ->where('category_code','<>','Security')
        ->select('category_code')
        ->groupby('category_code')
        ->distinct()
        ->get();

        return view('security.param_setting.index',compact('secure_param','groupparam'))
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

        request()->validate([
			'category_code' => 'required',
			'description' => 'required',
        ]);
        // dd($test2);

        Parameter_Category::create($request->all());

        return redirect()->route('paramsetting.index')
        ->with('success', 'Details created successfully.');
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
        $groupparam = DB::table('param_category')
        ->where('category_code','<>','Security')
        ->select('category_code')
        ->groupby('category_code')
        ->distinct()
        ->get();
        // view list in the form
        $param = DB::table('parameters')
        ->where('id', '=', $id)
        ->distinct()
        ->find($id);

        return view('security.param_setting.edit',compact('param','groupparam'));
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
        // $params = SecureParam::find($id);
        $params = DB::table('parameters')
        ->where('group', '=' , 'Security')
        ->where('id', '=' , $id);
        $params->id=$id;
        $params->group = $request->group;
        $params->param_value = $request->param_value;
        $params->value_details = $request->value_details;
        $params->description = $request->description;
        $params->user_lastmaintain = $request->user_lastmaintain;

        // $params->update($request->all());
        $params->save();

        return redirect()->route('paramsetting.index')
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

    public function store_param(Request $request)
    {

        request()->validate([
            'group' => 'required',
            'param_value' => 'required',
            'value_details' => 'required',
            'description' => 'required',
            'user_lastmaintain' => 'required',
        ]);
        // dd($test2);

        SecureParam::create($request->all());
        
        
        return redirect()->route('paramsetting.index')
        ->with('success', 'Details created successfully.');
    }


}
