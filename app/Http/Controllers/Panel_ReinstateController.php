<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PanelReinstate;
use App\EmailCase;
use DB;
use Hash;
use Carbon\Carbon;
use DataTables;

use App\Jobs\EncryptFile;
use App\Jobs\MoveFileToS3;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Files;

class Panel_ReinstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:panel_reinstate-list|panel_reinstate-create|panel_reinstate-edit|panel_reinstate-delete', ['only' => ['index','show']]);
        $this->middleware('permission:panel_reinstate-create', ['only' => ['create','store']]);
        $this->middleware('permission:panel_reinstate-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:panel_reinstate-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        // view list in the table
        // $reinstates = DB::table('ld_ststrackingheader')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->join('users','collaborator.ICode', '=', 'users.company')
        // ->where('TYPE','=','RIN')
        // ->distinct()
        // ->paginate(5);

        if ($request->ajax()) {
            $data = DB::table('ld_ststrackingheader')
                    ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                    ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                    // ->join('users','collaborator.ICode', '=', 'users.company')
                    ->where('TYPE','=','RIN')
                    ->where('ld_ststrackingheader.PANELSOLICITOR','=',\Auth::user()->company)
                    // ->where('users.company','=',\Auth::user()->company)
                    ->distinct()
                    ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('DTCREATED', function ($row) {
                        return $this->formatDate($row->DTCREATED);
                    })
                    ->editColumn('DTMEETING', function ($row) {
                        return $this->formatDate($row->DTMEETING);
                    })
                    ->addColumn('action', function($row){
                        if (request()->user()->can('panel_reinstate-edit')) {
                            $btn = '<a href="'. route('panelreinstate.show', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                            return $btn;
                        }else{

                        };
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        // view list in the dropdown menu for status
        $status = DB::table('parameters')
        ->where('group','=','case_status')
        ->distinct()
        ->get();

        // view list in the dropdown menu for applicant
        $applicant_list = DB::table('ld_ststrackingheader')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->join('users','collaborator.ICode', '=', 'users.company')
        ->where('ld_ststrackingheader.TYPE','=','RIN')
        ->distinct()
        ->get();

        return view('panel.reinstate.index',compact('applicant_list','status'))
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
			'sis_id' => 'required',
			'header_id' => 'required',
			'panel_update' => 'required',
			'pic' => 'required',
			'panel' => 'required',
			'details' => 'required',
			'status_comment' => 'required',
			'status_case' => 'required',
            'issue_date' => 'required',
			'return_date',
			'update_date' => 'required',
			'user_lastmaintain' => 'required'
        ]);

        
        // $reinstate = PanelReinstate::create($request->all());

        // dd($reinstate->cid);

        $panel = $request->get('panel_update');

        // dd($request->get('panel_update'));

        // get email sender
        $sender = DB::table('users')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('users.company',$request->get('panel'))
        ->where('users.fullname',$request->get('pic'))
        // ->where('users.company','!=',"PUNB")
        ->groupBy('email', 'company')
        ->get();

        // dd($sender);
        
        // get list of panel emails (receiver)
         $panel = DB::table('users')
        ->join('ld_ststrackingheader','ld_ststrackingheader.PANELSOLICITOR','=','users.company')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('ld_ststrackingheader.ID',$request->get('header_id'))
        ->where('users.company','!=',"PUNB")
        ->groupBy('email', 'company')
        ->get();
        // ->lists('email');

        // dd($test);
        $email = [];
        $company = [];

        foreach($panel as $value){
            $company[]=$value->company;

            $email[] = $value->email;
        };
        $email['email'] = implode(',', $email);
        $receiver_email = $email['email'];

        // if more than one panel
        $company['company'] = implode(',', $company);
        $receiver_company = $company['company'];

        // dd($receiver_company);
        // dd($receiver_email);


        // get list of punb emails (receiver)
        $punb = DB::table('users')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('users.company','PUNB')
        ->get();

        foreach($punb as $value2){
            $company2[]=$value2->company;

            $email2[] = $value2->email;
        };
        $email2['email'] = implode(',', $email2);
        $receiver_email2 = $email2['email'];

        // if more than one panel
        $company2['company'] = implode(',', $company2);
        $receiver_company2 = $company2['company'];

        
        $status_email="0";
    
        // $emailcase = DB::table('email_cases');
        if(empty($receiver_email)){
            // dd("Empty Yaww");
            return redirect()->back()->withErrors(['Error', 'Email receiver is empty. Please contact System Admin to register email receiver']);
            // dd($receiver_email);
        }
        else{
            // dd("not yempty");
            // dd($receiver_email);
            $reinstate = PanelReinstate::create($request->all());
            if( \Auth::user()->company == "PUNB" ){
            
                $emailcase = EmailCase::updateOrCreate([
                    'header_id' => $request->get('header_id'),
                    'sis_id' => $request->get('sis_id'),
                    'ref_no' => sprintf("%010d",$request->get('sis_id')),
                    'cid' => $reinstate->cid,
                    'details' => $request->get('details'),
                    'status_case' => $request->get('status_case'),
                    'company_sender' => $request->get('panel_update'),
                    'person_sender' => $request->get('pic'),
                    'company_receiver' => $receiver_company,
                    'person_receiver' => $receiver_email,
                    'status_email' => $status_email,
                    'user_lastmaintain' => $request->get('user_lastmaintain'),
                ]);

                // dd("email kepada panel");
            }else{

                $emailcase = EmailCase::updateOrCreate([
                    'header_id' => $request->get('header_id'),
                    'sis_id' => $request->get('sis_id'),
                    'ref_no' => sprintf("%010d",$request->get('sis_id')),
                    'cid' => $reinstate->cid,
                    'details' => $request->get('details'),
                    'status_case' => $request->get('status_case'),
                    'company_sender' => $request->get('panel_update'),
                    'person_sender' => $request->get('pic'),
                    'company_receiver' => $receiver_company2,
                    'person_receiver' => $receiver_email2,
                    'status_email' => $status_email,
                    'user_lastmaintain' => $request->get('user_lastmaintain'),
                ]);

                // dd("email kepada punb");
                
            };
        }
        // if( \Auth::user()->company == "PUNB" ){
           
        //     $emailcase = EmailCase::updateOrCreate([
        //         'header_id' => $request->get('header_id'),
        //         'sis_id' => $request->get('sis_id'),
        //         'ref_no' => sprintf("%010d",$request->get('sis_id')),
        //         'cid' => $financing->cid,
        //         'details' => $request->get('details'),
        //         'status_case' => $request->get('status_case'),
        //         'company_sender' => $request->get('panel_update'),
        //         'person_sender' => $request->get('pic'),
        //         'company_receiver' => $receiver_company,
        //         'person_receiver' => $receiver_email,
        //         'status_email' => $status_email,
        //         'user_lastmaintain' => $request->get('user_lastmaintain'),
        //     ]);

        //     // dd("email kepada panel");
        // }else{

        //     $emailcase = EmailCase::updateOrCreate([
        //         'header_id' => $request->get('header_id'),
        //         'sis_id' => $request->get('sis_id'),
        //         'ref_no' => sprintf("%010d",$request->get('sis_id')),
        //         'cid' => $financing->cid,
        //         'details' => $request->get('details'),
        //         'status_case' => $request->get('status_case'),
        //         'company_sender' => $request->get('panel_update'),
        //         'person_sender' => $request->get('pic'),
        //         'company_receiver' => $receiver_company,
        //         'person_receiver' => $receiver_email,
        //         'status_email' => $status_email,
        //         'user_lastmaintain' => $request->get('user_lastmaintain'),
        //     ]);

        //     // dd("email kepada punb");
            
        // };

        return redirect()->route('panelreinstate.edit', $request->sis_id)
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
        $reins = DB::table('ppsis_headers')
            // ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=','sis_headers.header_id' )
            ->join('parameters','parameters.param_value', '=','ppsis_headers.status' )
            // ->where('ld_ststrackingheader.TYPE','=','STL')
            ->where('parameters.group','=','case_status')
            ->where('ppsis_headers.header_id','=', $id )
            ->select('sis_id','product','case_no','value_details')
            ->selectRaw($this->dateFormatQuery([
                'ppsis_headers', 'created_at'
            ])) 
            // ->select('ppsis_headers.header_id','ppsis_headers.sis_id','ppsis_headers.product','ppsis_headers.case_no')
            ->distinct()
            ->get();

            // dd($finan);

        
        return view('panel.reinstate.show', compact('reins'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $id;

        // header details
        $reinstates = DB::table('ld_ststrackingheader')
        ->select('*', 'parameters.value_details AS value_details')
        ->join('ppsis_headers', 'ppsis_headers.header_id','=','ld_ststrackingheader.ID')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->join('parameters','parameters.value_details', '=','ld_ststrackingheader.TYPE' )
        ->join('parameters','parameters.param_value', '=','ppsis_headers.status' )
        ->join('parameters AS param2','param2.value_details', '=', 'ld_ststrackingheader.TYPE' )
        ->where('parameters.group','=','case_status')
        // ->where('parameters.group','=','case_status')
        ->where('ld_ststrackingheader.TYPE','=','RIN')
        ->where('ppsis_headers.sis_id','=',$id)
        ->first();

        // body details
        $com_reins = DB::table('reinstates')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'reinstates.header_id')
        ->join('ppsis_headers', 'ppsis_headers.sis_id','=','reinstates.sis_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->where('TYPE','=','RIN')
        ->where('status_comment','=','Active')
        // ->orWhere()
        ->where('ppsis_headers.sis_id','=',$id)
        ->distinct();
        // ->paginate(5);
        $com_reins = (request()->output === 'print') ? $com_reins->get() : $com_reins->paginate(5);

        // case status
        $case_status = DB::table('reinstates')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'reinstates.header_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->select('header_id','status_case')
        ->where('TYPE','=','RIN')
        ->groupby('header_id','status_case')
        ->distinct()
        ->paginate(5);


        // status close case
        $statuscase = DB::table('reinstates')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'reinstates.header_id')
        ->join('ppsis_headers', 'ppsis_headers.sis_id','=','reinstates.sis_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->select('status_case')
        ->where('TYPE','=','RIN')
        ->where('status_case','=','Closed')
        ->where('ppsis_headers.sis_id','=',$id)
        ->groupby('status_case')
        ->distinct()
        ->get();

        if ($request->ajax()) {
            $data = 
            DB::table('reinstates')
            ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'reinstates.header_id')
            ->join('ppsis_headers', 'ppsis_headers.sis_id','=','reinstates.sis_id')
            ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
            // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
            ->join('collaborator','collaborator.ICode', '=', 'reinstates.panel_update')

            ->where('TYPE','=','RIN')
            // ->where('status_comment','=','Active')
            // ->where('panel_update','=',\Auth::user()->company)
            // ->orWhere()
            ->where('ppsis_headers.sis_id','=',$id)
            ->distinct()
            ->get();
            

            if ($statuscase->count()){
                    return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('update_date', function ($row) {
                        return $this->formatDate($row->update_date);
                    })
                    ->editColumn('details', function ($row) {
                        return nl2br($row->details);
                    })
                    ->addColumn('action', function($row){
                        $btn = ''; 
                    return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                            }
            else{
                // if($comm->panel_update == \Auth::user()->company){
                    return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('update_date', function ($row) {
                        return $this->formatDate($row->update_date);
                    })
                    ->editColumn('details', function ($row) {
                        return nl2br($row->details);
                    })
                    ->addColumn('action', function($row){  
                        // $btn = 'TEST 2';
                        if($row->status_comment == 'Active'){
                            // $btn = '<button type="submit" value="Hide" class="btn btn-danger btn-sm" ><i class="icon-copy dw dw-hide"></i></button></button>';
                            // $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-original-title="Hide" class="btn btn-danger btn-sm HideItem"><i class="icon-copy dw dw-hide"></i></i></a>'; 
																					
                            // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Hide" class="btn btn-danger btn-sm HideItem"><i class="icon-copy dw dw-hide"></i></i></a>'; 
                            $btn ='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Hide" class="btn btn-danger btn-sm HideItem">Hide</a> 
                            <a class="btn btn-info btn-sm" id="show-user" data-toggle="modal" data-id='.$row->cid.'>Show</a>'; 
                        }else{
                            // $btn = '<button type="submit" value="Hide" class="btn btn-primary btn-sm" ><i class="icon-copy dw dw-view"></i></button></button>'; 
                            // $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-primary btn-sm ActiveItem"><i class="icon-copy dw dw-view"></i></a>'; 
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-success btn-sm ActiveItem">Unhide</a> 
                            <a class="btn btn-info btn-sm" id="show-user" data-toggle="modal" data-id='.$row->cid.'>Show</a>'; 
                        }
                        
                        if($row->panel_update == \Auth::user()->company){
                            return $btn;
                        }
                    })
                    ->rawColumns(['action','details'])
                    ->make(true);
                /*}
                else
                {

                }*/                   
            }
            
        }

        $stat = DB::table('parameters')
            ->where('group','Comment_Status')
           ->get();


         $listfile = DB::table('files')
         ->selectRaw('*, ' . $this->dateFormatQuery([
             'files', 'updated_at'
         ]))
         ->where('files.sis_id','=',$id)
         ->distinct()
         ->paginate(5);
 
         $current_time = Carbon::now();
 
 
         $files = Storage::files('files/' . $id);

        if (request()->output === 'print') {
            $headers = $reinstates;
            $body = $com_reins;
            $pdf = \PDF::loadView('panel.reinstate.reinstatePrint',compact('headers','body','current_time','case_status','statuscase'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->setOptions([
                'isPhpEnabled' => true
            ]);
            // return view('punb.financing.financingPrint',compact('financings','com_finan','current_time','case_status','statuscase'));
            // ->with('i', (request()->input('page', 1) - 1) * 5);
            return $pdf->stream();
        }

        return view('panel.reinstate.edit', compact('id','stat', 'reinstates','com_reins','statuscase','current_time','files','listfile'))
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
        $request->validate([
            'header_id' => 'required',
            'user_lastmaintain' => 'required',
        ]);

        // $closed = "Closed";
        $req_close = "Request to close";
        $reqclose = "2";

        $current_date_time = Carbon::now()->format('d F Y');


        $panel = $request->get('panel_update');

        // get email sender
        $sender = DB::table('users')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('users.company',$request->get('panel'))
        ->where('users.fullname',$request->get('pic'))
        // ->where('users.company','!=',"PUNB")
        ->groupBy('email', 'company')
        ->get();

        // get list of panel emails (receiver)
        $panel = DB::table('users')
        ->join('ld_ststrackingheader','ld_ststrackingheader.PANELSOLICITOR','=','users.company')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('ld_ststrackingheader.ID',$request->get('header_id'))
        ->where('users.company','!=',"PUNB")
        ->groupBy('email', 'company')
        ->get();
        // ->lists('email');


        $email = [];
        $company = [];

       foreach($panel as $value){
           $company[]=$value->company;

           $email[] = $value->email;
       };

       // dd($email);
       $email['email'] = implode(', ', $email);
       $receiver_email = $email['email'];

       // if more than one panel
       $company['company'] = implode(', ', $company);
       $receiver_company = $company['company'];

       // get list of punb emails (receiver)
       $punb = DB::table('users')
       ->select('users.email as email','users.company as company')
       ->distinct()
       ->where('users.company','PUNB')
       ->get();

       foreach($punb as $value2){
           $company2[]=$value2->company;

           $email2[] = $value2->email;
       };
       $email2['email'] = implode(',', $email2);
       $receiver_email2 = $email2['email'];


       // if more than one panel
       $company2['company'] = implode(',', $company2);
       $receiver_company2 = $company2['company'];

       
       $status_email="0";

       if(empty($receiver_email)){
        // dd("Empty Yaww");
        return redirect()->back()->withErrors(['Error', 'Email receiver is empty. Please contact System Admin to register email receiver']);
        // dd($receiver_email);
    }
    else{
        // dd("not yempty");
        // dd($receiver_email);
        $financing = PanelReinstate::create($request->all());
        if( \Auth::user()->company == "PUNB" ){
        
            $emailcase = EmailCase::updateOrCreate([
                'header_id' => $request->get('header_id'),
                'sis_id' => $request->get('sis_id'),
                'ref_no' => sprintf("%010d",$request->get('sis_id')),
                'cid' => $financing->cid,
                'details' => $request->get('details'),
                'status_case' => $request->get('status_case'),
                'company_sender' => $request->get('panel_update'),
                'person_sender' => $request->get('pic'),
                'company_receiver' => $receiver_company,
                'person_receiver' => $receiver_email,
                'status_email' => $status_email,
                'user_lastmaintain' => $request->get('user_lastmaintain'),
            ]);

            // dd("email kepada panel");
        }else{

            $emailcase = EmailCase::updateOrCreate([
                'header_id' => $request->get('header_id'),
                'sis_id' => $request->get('sis_id'),
                'ref_no' => sprintf("%010d",$request->get('sis_id')),
                'cid' => $financing->cid,
                'details' => $request->get('details'),
                'status_case' => $request->get('status_case'),
                'company_sender' => $request->get('panel_update'),
                'person_sender' => $request->get('pic'),
                'company_receiver' => $receiver_company2,
                'person_receiver' => $receiver_email2,
                'status_email' => $status_email,
                'user_lastmaintain' => $request->get('user_lastmaintain'),
            ]);

            // dd("email kepada punb");
            
        };
    }

        $commenthead = DB::table('reinstates')
        ->where('sis_id', '=' , $id);
        $commenthead->header_id = $request->get('header_id');
        $commenthead->sis_id = $request->get('sis_id');
        $commenthead->status_case = $req_close;
        $commenthead->user_lastmaintain = $request->get('user_lastmaintain');
        
        $commenthead->update([
            'header_id' => $request->header_id,
            'sis_id' => $request->sis_id,
            'status_case' => $req_close,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        $ppsis_headers = DB::table('ppsis_headers')
        ->where('sis_id', '=' , $id);
        $ppsis_headers->header_id = $request->get('header_id');
        $ppsis_headers->sis_id = $request->get('sis_id');
        $ppsis_headers->status_case = $reqclose;
        $ppsis_headers->user_lastmaintain = $request->get('user_lastmaintain');
        
        $ppsis_headers->update([
            'header_id' => $request->header_id,
            'sis_id' => $request->sis_id,
            'status' => $reqclose,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        return redirect()->route('panelreinstate.edit', $request->sis_id)
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

    public function PRINstatusActiveCase(Request $request, $id)
    {
        $active = "Active";
        $coba = PanelReinstate::updateOrCreate(['cid' => $request->Item_id],
                ['status_comment' => $active], ['user_lastmaintain' => $request->user_lastmaintain]);        

        return response()->json(['success'=>'Item saved successfully.']);

    }
    public function PRINstatusHideCase(Request $request, $id)
    {
        $active = "Hide";
        $coba = PanelReinstate::updateOrCreate(['cid' => $request->Item_id],
                ['status_comment' => $active], ['user_lastmaintain' => $request->user_lastmaintain]);        

        return response()->json(['success'=>'Item saved successfully.']);
        
    }

    // public function PRINstatusCase(Request $request, $id)
    // {
    //     $request->validate([
    //         'header_id' => 'required',
    //         'cid' => 'required',
    //         'user_lastmaintain' => 'required',
    //     ]);

    //     $hide = "Hide";

    //     $commentline = PanelReinstate::find($id);
    //     $commentline->cid=$id;
    //     $commentline->status_comment = $hide;
    //     $commentline->user_lastmaintain = $request->user_lastmaintain;

    //     // $params->update($request->all());
    //     $commentline->save();

    //     return redirect()->route('panelreinstate.edit', $request->header_id)
    //     ->with('success', 'Details Update successfully.');
    // }

    public function PanelViewCommentReinst($id)
    {
        // dd($id);
        $data =  DB::table('reinstates')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->select('ID','FULLNAME', 'IDNO', 'Address', 'PRDABBR', 'DTCREATED', 'AMOUNT', 'DTMEETING')
        // ->where('TYPE','=','STL')
        ->where('cid', '=',$id)
        ->distinct()
        ->first();        

        // $where = array('id' => $id);
        // $datas = User::where($where)->first();
        // return dd(json_encode($data));
        // return Response::json($data);
        return response()->json(($data));

        //return view('users.show',compact('user'));
        
    }
}
