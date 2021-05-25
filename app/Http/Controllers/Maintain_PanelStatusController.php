<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use DataTables;

class Maintain_PanelStatusController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:punb_panelstatus-list|punb_panelstatus-create|punb_panelstatus-edit|punb_panelstatus-delete', ['only' => ['index','show']]);
        $this->middleware('permission:punb_panelstatus-create', ['only' => ['create','store']]);
        $this->middleware('permission:punb_panelstatus-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:punb_panelstatus-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->filter_fullname))
            {
                $data =  DB::table('collaborator')
                ->join('parameters','parameters.param_value', '=', 'collaborator.SoliStatus')
                ->where('Name', $request->filter_fullname)
                ->where('parameters.group','=', 'soli_status')
                ->distinct()
                ->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if (request()->user()->can('punb_panelstatus-edit')) {
                            // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                            $btn = '<a href="'. route('panelstatus.edit', $row->ICode ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                            return $btn;
                        }else{
    
                        };
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            else
            {
                $data = DB::table('collaborator')
                ->join('parameters','parameters.param_value', '=', 'collaborator.SoliStatus')
                ->where('parameters.group','=', 'soli_status')
                ->distinct()
                ->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if (request()->user()->can('punb_panelstatus-edit')) {
                        // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                        $btn = '<a href="'. route('panelstatus.edit', $row->ICode ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                        return $btn;
                    }else{
    
                    };
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return datatables()->of($data)->make(true);
        }

        // view list in the table
        // $panels = DB::table('collaborator')
        // ->distinct()
        // ->paginate(5);


        // view list in the dropdown menu
        $panel_list = DB::table('collaborator')
        ->get();

        return view('maintenance.panel_status.index',compact('panel_list'));
        // ->with('i', (request()->input('page', 1) - 1) * 5);

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
        // Panels Details
        $panels = DB::table('collaborator')
        ->where('collaborator.ICode','=', $id )
        ->distinct()
        ->get();
        
        // list of users under the company
        $panelset = DB::table('collaborator')
        ->join('users','users.company', '=', 'collaborator.ICode')
        ->where('collaborator.ICode','=', $id )
        ->distinct()
        ->get();

        $panels =  $panels[0];

        //  dd($panels);
         return view('maintenance.panel_status.edit',compact('panels','panelset'))
         ->with('i', (request()->input('page', 1) - 1) * 5);
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
