<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PunbVlo;
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


class Punb_VloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:punb_vlo-list|punb_vlo-create|punb_vlo-edit|punb_vlo-delete', ['only' => ['index','show']]);
        $this->middleware('permission:punb_vlo-create', ['only' => ['create','store']]);
        $this->middleware('permission:punb_vlo-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:punb_vlo-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        // view list in the table
        // $vlos = DB::table('ld_ststrackingheader')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->where('TYPE','=','VLO')
        // ->distinct()
        // ->paginate(5);

        if(request()->ajax())
        {
            if(!empty($request->filter_fullname))
            {
                $data =  DB::table('ld_ststrackingheader')
                ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                // ->join('parameters','parameters.param_value', '=', 'ld_ststrackingheader.TRACK')
                // ->select('ID','FULLNAME', 'IDNO', 'Address', 'PRDABBR', 'DTCREATED', 'AMOUNT', 'DTMEETING')
                ->where('TYPE','=','VLO')
                ->where('FULLNAME', $request->filter_fullname)
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
                            // $btn = '<a href="'. route('punbvlo.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                            if (request()->user()->can('punb_vlo-edit')) {
                                $btn = '
                                <a href="'. route('punbvlo.show', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
                                ';
                                return $btn;
                            }else{
    
                            };
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            else
            {
                $data =  DB::table('ld_ststrackingheader')
                ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                // ->select('ID','FULLNAME', 'IDNO', 'Address', 'PRDABBR', 'DTCREATED', 'AMOUNT', 'DTMEETING')
                ->where('TYPE','=','VLO')
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
                        // $btn = '<a href="'. route('punbvlo.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                        // $btn = '<a href="'. route('punbvlo.show', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                        if (request()->user()->can('punb_vlo-edit')) {
                            $btn = '
                            <a href="'. route('punbvlo.show', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
                            ';
                            return $btn;
                        }else{

                        };
                        
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return datatables()->of($data)->make(true);
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
        ->where('ld_ststrackingheader.TYPE','=','VLO')
        ->distinct()
        ->get();

        return view('punb.vlo.index',compact('applicant_list','status'))
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

        // $vlo = PunbVlo::create($request->all());

        // dd($vlo->cid);

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
            $vlo = PunbVlo::create($request->all());
            if( \Auth::user()->company == "PUNB" ){
            
                $emailcase = EmailCase::updateOrCreate([
                    'header_id' => $request->get('header_id'),
                    'sis_id' => $request->get('sis_id'),
                    'ref_no' => sprintf("%010d",$request->get('sis_id')),
                    'cid' => $vlo->cid,
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
                    'cid' => $vlo->cid,
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


        return redirect()->route('punbvlo.edit', $request->sis_id)
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
        $vlos = DB::table('ppsis_headers')
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
            ->paginate(5);
            // ->get();

            // dd($finan);

        
        return view('punb.vlo.show', compact('vlos'))
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
          /// header details
        //   $vlos = DB::table('ld_ststrackingheader')
        //   ->join('ppsis_headers', 'ppsis_headers.header_id','=','ld_ststrackingheader.ID')
        //   ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        //   ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        //   // ->join('parameters','parameters.value_details', '=','ld_ststrackingheader.TYPE' )
        //   ->join('parameters','parameters.param_value', '=','ppsis_headers.status' )
        //   ->join('parameters AS param2','param2.value_details', '=', 'ld_ststrackingheader.TYPE' )
        //   ->where('parameters.group','=','case_status')
        //   // ->where('parameters.group','=','case_status')
        //   ->where('ld_ststrackingheader.TYPE','=','VLO')
        //   ->where('ppsis_headers.sis_id','=',$id)
        //   ->first();
          $vlos = DB::table('ld_ststrackingheader')
          ->select('*', 'parameters.value_details as case_satatus','param2.description AS status','param3.description AS track' )
          ->join('ppsis_headers', 'ppsis_headers.header_id','=','ld_ststrackingheader.ID')
          ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
          ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
          ->join('parameters','parameters.param_value', '=','ppsis_headers.status' )
          ->join('parameters AS param2','param2.value_details', '=', 'ld_ststrackingheader.TYPE' )
          ->join('parameters AS param3','param3.param_value', '=', 'ld_ststrackingheader.TRACK')
          ->where('parameters.group','=','case_status')
          ->where('param3.group','=','VLO_Tracking')
          ->where('ld_ststrackingheader.TYPE','=','VLO')
          ->where('ppsis_headers.sis_id','=',$id)
          ->first();


        // body details
        $com_vlo = DB::table('vlos')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'vlos.header_id')
        ->join('ppsis_headers', 'ppsis_headers.sis_id','=','vlos.sis_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->where('TYPE','=','VLO')
        ->where('status_comment','=','Active')
        // ->orWhere()
        ->where('ppsis_headers.sis_id','=',$id)
        ->distinct();
        // ->paginate(5);
        $com_vlo = (request()->output === 'print') ? $com_vlo->get() : $com_vlo->paginate(5);

        // case status
        $case_status = DB::table('vlos')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'vlos.header_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->select('header_id','status_case')
        ->where('TYPE','=','VLO')
        ->groupby('header_id','status_case')
        ->distinct()
        ->paginate(5);

       
        // status close case
        $statuscase = DB::table('vlos')
        ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'vlos.header_id')
        ->join('ppsis_headers', 'ppsis_headers.sis_id','=','vlos.sis_id')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->select('status_case')
        ->where('TYPE','=','VLO')
        ->where('status_case','=','Closed')
        // ->where('ID','=', $id )
        ->where('ppsis_headers.sis_id','=',$id)

        ->groupby('status_case')
        ->distinct()
        ->get();

        if ($request->ajax()) {
            $data = 
            DB::table('vlos')
            ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'vlos.header_id')
            ->join('ppsis_headers', 'ppsis_headers.sis_id','=','vlos.sis_id')
            ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
            // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
            ->join('collaborator','collaborator.ICode', '=', 'vlos.panel_update')

            ->where('TYPE','=','VLO')
            // ->where('status_comment','=','Active')
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
                    return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('update_date', function ($row) {
                        return $this->formatDate($row->update_date);
                    })
                    ->editColumn('details', function ($row) {
                        return nl2br($row->details);
                    })
                    ->addColumn('action', function($row){  
                        if($row->status_comment == 'Active'){														
                            // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Hide" class="btn btn-danger btn-sm HideItem"><i class="icon-copy dw dw-hide"></i></i></a>'; 
                            $btn ='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Hide" class="btn btn-danger btn-sm HideItem">Hide</a> 
                            <a class="btn btn-info btn-sm" id="show-user" data-toggle="modal" data-id='.$row->cid.'>Show</a>';  
                        }else{
                            // $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-primary btn-sm ActiveItem"><i class="icon-copy dw dw-view"></i></a>'; 
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->cid.'" data-user="'.\Auth::user()->fullname.'" data-original-title="Active" class="btn btn-success btn-sm ActiveItem">Unhide</a> 
                            <a class="btn btn-info btn-sm" id="show-user" data-toggle="modal" data-id='.$row->cid.'>Show</a>';
                        }
                        
                        if($row->panel_update == \Auth::user()->company){
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);                
            }
            
        }

        $listfile = DB::table('files')
        ->selectRaw('*, ' . $this->dateFormatQuery([
            'files', 'updated_at'
        ]))
        ->where('files.sis_id','=',$id)
        ->distinct()
        ->paginate(5);
        // ->get();

        $stat = DB::table('parameters')
        ->where('group','Comment_Status')
        ->get();

        $current_time = Carbon::now();

        $files = Storage::files('files/' . $id);

        if (request()->output === 'print') {
            $headers = $vlos;
            $body = $com_vlo;
            $pdf = \PDF::loadView('punb.vlo.vloPrint',compact('headers','body','current_time','case_status','statuscase'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->setOptions([
                'isPhpEnabled' => true
            ]);
            // return view('punb.vlo.vloPrint',compact('vlos','com_finan','current_time','case_status','statuscase'));
            // ->with('i', (request()->input('page', 1) - 1) * 5);
            return $pdf->stream();
        }

        return view('punb.vlo.edit',compact('id','stat','vlos','com_vlo','current_time','case_status','statuscase','listfile'))
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
            'sis_id' => 'required',
            'header_id' => 'required',
            'user_lastmaintain' => 'required',
        ]);
        //update table financing
        $closed = "Closed";

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
           $financing = PunbVlo::create($request->all());
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

        $commenthead = DB::table('vlos')
        // ->where('header_id', '=' , $id);
        ->where('sis_id', '=' , $id);

        $commenthead->sis_id = $request->get('sis_id');
        $commenthead->header_id = $request->get('header_id');
        $commenthead->status_case = $closed;
        $commenthead->user_lastmaintain = $request->get('user_lastmaintain');
        
        $commenthead->update([
            // 'sis_id' => $request->sis_id,
            // 'header_id' => $request->header_id,
            'status_case' => $closed,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        //update table header
        $sishead = DB::table('ppsis_headers')
        ->where('sis_id', '=' , $id);

        $closes = "0";
       
        
        $sishead->update([
            // 'header_id' => $request->header_id,
            'status' => $closes,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        return redirect()->route('punbvlo.edit', $request->sis_id)
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

    public function VLOstatusActiveCase(Request $request, $id)
    {
        $active = "Active";
        $coba = PunbVlo::updateOrCreate(['cid' => $request->Item_id],
                ['status_comment' => $active], ['user_lastmaintain' => $request->user_lastmaintain]);        

        return response()->json(['success'=>'Item saved successfully.']);

    }
    public function VLOstatusHideCase(Request $request, $id)
    {
        $active = "Hide";
        $coba = PunbVlo::updateOrCreate(['cid' => $request->Item_id],
                ['status_comment' => $active], ['user_lastmaintain' => $request->user_lastmaintain]);        

        return response()->json(['success'=>'Item saved successfully.']);
        
    }


    public function downloadFile($filename, Request $request)
    {
        return Storage::download('files/' . $request->sis_id . '/' . $request->filename);
    }

    public function ViewCommentVlo($id)
    {
        // dd($id);
        $data =  DB::table('vlos')
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
