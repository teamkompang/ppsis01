<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PanelNewFinancing;
use App\Ppsis_Header;
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

class Panel_NewFinancingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(\Auth::user()->company);
        if ($request->ajax()) {
            $data = DB::table('new_financing')
                    // ->selectRaw(*, '')
                    // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                    ->join('collaborator','collaborator.ICode', '=', 'new_financing.PANELSOLICITOR')
                    ->join('parameters','parameters.param_value', '=', 'new_financing.PROFITCNTR')

                    // ->join('users','collaborator.ICode', '=', 'users.company')
                    // ->where('TYPE','=','STL')
                    // ->where('users.company','=',\Auth::user()->company)
                    ->where('new_financing.PANELSOLICITOR','=',\Auth::user()->company)
                    ->distinct()
                    ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('DTAPPLIED', function ($row) {
                        // Illuminate\Routing\Controller @formatDate
                        return $this->formatDate($row->DTAPPLIED);
                        // return $row->DTCREATED ? with(new Carbon($row->DTCREATED))->format('d/m/Y h:i:s') : '';
                    })
                    ->editColumn('DTAPPROVED', function ($row) {
                        return $this->formatDate($row->DTAPPROVED);
                        // return $row->DTMEETING ? with(new Carbon($row->DTMEETING))->format('d/m/Y') : '';
                    })
                    ->addColumn('action', function($row){
                        if (request()->user()->can('panel_financing-edit')) {
                            $btn = '<a href="'. route('panelnewfinancing.show', $row->APPREF ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
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
        $applicant_list = DB::table('new_financing')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'new_financing.PANELSOLICITOR')
        ->join('users','collaborator.ICode', '=', 'users.company')
        // ->where('ld_ststrackingheader.TYPE','=','STL')
        ->distinct()
        ->get();

        return view('panel.newfinancing.index',compact('applicant_list','status'));
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
        $datereturn = "No";

        // dd($request);

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

        // $financing = PanelFinancing::create($request->all());

        // dd($financing->cid);

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
        ->join('new_financing','new_financing.PANELSOLICITOR','=','users.company')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('new_financing.APPREF',$request->get('header_id'))
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

        // dd($receiver_email);

        // dd($receiver_company);

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
            $financing = PanelNewFinancing::create($request->all());
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
        // if( \Auth::user()->company == 'PUNB' ){
           
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

        return redirect()->route('panelnewfinancing.edit', $request->sis_id)
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
        $finan = DB::table('ppsis_headers')
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

        
        return view('panel.newfinancing.show', compact('finan'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $id;
        // dd($id);
        $financings = DB::table('new_financing')
        // ->select('*', 'parameters.value_details AS value_details')
        ->select('*','APPREF as ID', 'parameters.value_details AS value_details','new_financing.PANELSOLICITOR as ICode','new_financing.DTAPPROVED as DTMEETING','cf1.value_details as description', 'cf2.value_details as FACSTATUS',  'cf3.value_details as scheme')
        // ->select('*','ppsis_headers.sis_id','APPREF as ID','PROFITCNTR','new_financing.FULLNAME','cf1.value_details as description', 'new_financing.FULLNAME as Name','cf2.value_details as FACSTATUS', 'new_financing.APPREF', 'cf3.value_details as scheme', 'p.value_details AS case_status', 'parameters.description AS app_type')
        ->join('ppsis_headers', 'ppsis_headers.header_id','=','new_financing.APPREF')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'new_financing.PANELSOLICITOR')
        ->join('parameters as cf1','new_financing.APPSTS', '=', 'cf1.param_value')
        ->join('parameters as cf2','new_financing.APPSTS', '=', 'cf2.param_value')
        ->join('parameters as cf3','new_financing.PROFITCNTR', '=', 'cf3.param_value')
        ->join('parameters','parameters.param_value', '=','ppsis_headers.status' )
        // ->join('parameters','parameters.param_value', '=', 'new_financing.APPSTS')
        // ->join('parameters AS p','ppsis_headers.status', '=', 'p.param_value')
        ->where('parameters.group','=','case_status')
        ->where('new_financing.APPSTS','=','30')
        ->where('ppsis_headers.sis_id','=',$id)
        ->first();

        // dd($financings);
        // dd(\Auth::user()->company);

        // body details
        $com_finan = DB::table('nf_financings')
        ->join('new_financing','new_financing.APPREF', '=', 'nf_financings.header_id')
        ->join('ppsis_headers', 'ppsis_headers.sis_id','=','nf_financings.sis_id')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->where('APPSTS','=','30')
        ->where('status_comment','=','Active')
        // ->orWhere()
        ->where('ppsis_headers.sis_id','=',$id)
        ->distinct();

        $com_finan = (request()->output === 'print') ? $com_finan->get() : $com_finan->paginate(5);

         // status close case
         $statuscase = DB::table('nf_financings')
         ->join('new_financing','new_financing.APPREF', '=', 'nf_financings.header_id')
         ->join('ppsis_headers', 'ppsis_headers.sis_id','=','nf_financings.sis_id')
        //  ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        //  ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
         ->select('status_case')
         ->where('APPSTS','=','30')
         ->where('status_case','=','Closed')
         ->where('ppsis_headers.sis_id','=',$id)
         ->groupby('status_case')
         ->distinct()
         ->get();

        //  dd($statuscase);

         $stat = DB::table('parameters')
         ->where('group','Comment_Status')
        ->get();

        // dd($stat);

        if ($request->ajax()) {
            $data = 
            DB::table('nf_financings')
            // ->select('*', 'collaborator.Name AS panel_name')
            ->select('*','status_comment','APPREF as ID','PROFITCNTR','new_financing.FULLNAME', 'new_financing.APPREF','new_financing.PANELSOLICITOR as ICode')
            ->join('new_financing','new_financing.APPREF', '=', 'nf_financings.header_id')
            ->join('ppsis_headers', 'ppsis_headers.sis_id','=','nf_financings.sis_id')
            // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
            ->join('collaborator','collaborator.ICode', '=', 'nf_financings.panel_update')
            // ->join('collaborator','collaborator.ICode', '=', 'financings.panel_update')
            ->where('APPSTS','=','30')
            // ->where('financings.panel_update','=','collaborator.ICode')
            // ->where('status_comment','=','Active')
            // ->where('panel_update','=',\Auth::user()->company)
            // ->orWhere()
            ->where('ppsis_headers.sis_id','=',$id)
            ->distinct()
            ->get();
            
            // dd($data);

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
                            // $btn ='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Hide" class="btn btn-primary btn-sm HideItem"><i class="icon-copy dw dw-view"></i></a> 
                            $btn ='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Hide" class="btn btn-danger btn-sm HideItem">Hide</a> 
                            <a class="btn btn-info btn-sm" id="show-user" data-toggle="modal" data-id='.$row->cid.'>Show</a>'; 

                        }else{
                            // $btn = '<button type="submit" value="Hide" class="btn btn-primary btn-sm" ><i class="icon-copy dw dw-view"></i></button></button>'; 
                            // $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-primary btn-sm ActiveItem"><i class="icon-copy dw dw-view"></i></a>'; 
                            // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-primary btn-sm ActiveItem"><i class="icon-copy dw dw-view"></i></a>'; 
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-success btn-sm ActiveItem">Unhide</a> 
                            <a class="btn btn-info btn-sm" id="show-user" data-toggle="modal" data-id='.$row->cid.'>Show</a>'; 
                        }
                        
                        if($row->panel_update == \Auth::user()->company){
                            // return ([$btn]);
                            // return ($btn);
                            return $btn;

                        }
                    })
                    ->rawColumns(['action', 'details'])
                    ->make(true);
                /*}
                else
                {

                }*/                   
            }
            
        }

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
            $headers = $financings;
            $body = $com_finan;
            $pdf = \PDF::loadView('panel.newfinancing.financingPrint', compact('headers','body','statuscase','current_time'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->setOptions([
                'isPhpEnabled' => true
            ]);
            // return view('panel.financing.financingPrint', compact('headers','body','statuscase','current_time'));
            // ->with('i', (request()->input('page', 1) - 1) * 5);
            return $pdf->stream();
        }
       

        return view('panel.newfinancing.edit',compact('id','stat','financings','com_finan','statuscase','current_time','files','listfile'))
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
        ->join('new_financing','new_financing.PANELSOLICITOR','=','users.company')
        ->select('users.email as email','users.company as company')
        ->distinct()
        ->where('new_financing.APPREF',$request->get('header_id'))
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
        $financing = PanelNewFinancing::create($request->all());
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

        $commenthead = DB::table('nf_financings')
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

        return redirect()->route('panelnewfinancing.edit', $request->sis_id)
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

    public function NFstatusActiveCase(Request $request, $id)
    {
        // dd($request);
        $active = "Active";
        $coba = PanelNewFinancing::updateOrCreate(['cid' => $request->Item_id],
                ['status_comment' => $active], ['user_lastmaintain' => $request->user_lastmaintain]);        

        return response()->json(['success'=>'Item saved successfully.']);
        
    }
    public function NFstatusHideCase(Request $request, $id)
    {
        // dd($request);
        $active = "Hide";
        $coba = PanelNewFinancing::updateOrCreate(['cid' => $request->Item_id],
                ['status_comment' => $active], ['user_lastmaintain' => $request->user_lastmaintain]);        

        return response()->json(['success'=>'Item saved successfully.']);
        
    }

    public function downloadFile($filename, Request $request)
    {

        return Storage::download('files/' . $request->sis_id . '/' . $request->filename);

    }


    public function ViewComment($id)
    {
        $data =  DB::table('nf_financings')
        ->where('cid', '=',$id)
        ->distinct()
        ->first();        
        return response()->json(($data));
        
    }
}
