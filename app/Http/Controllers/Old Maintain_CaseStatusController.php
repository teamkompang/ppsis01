<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\PunbFinancing;
use App\PunbRestructure;
use App\PunbReinstate;
use App\PunbVLO;
use App\EmailCase;
use App\Ppsis_Header;
use Carbon\Carbon;
use DataTables;

class Maintain_CaseStatusController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:punb_casestatus-list|punb_casestatus-create|punb_casestatus-edit|punb_casestatus-delete', ['only' => ['index','show']]);
        $this->middleware('permission:punb_casestatus-create', ['only' => ['create','store']]);
        $this->middleware('permission:punb_casestatus-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:punb_casestatus-delete', ['only' => ['destroy']]);
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
            if(!empty($request->filter_fullname == 'fin'))
            {
                // $data =  DB::table('ld_ststrackingheader')
                // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                // ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
                // ->where('FULLNAME', $request->filter_fullname)
                // ->where('parameters.group','=', 'Type')
                // ->distinct()
                // ->get();
                // return Datatables::of($data)
                //     ->addIndexColumn()
                //     ->addColumn('action', function($row){
                //         if (request()->user()->can('punb_casestatus-edit')) {
                //             // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                //             $btn = '<a href="'. route('casestatus.edit', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                //             return $btn;
                //         }else{
    
                //         };
                //     })
                //     ->rawColumns(['action'])
                //     ->make(true);
                $data =  DB::table('new_financing')
                // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                // ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
                // ->where('FULLNAME', $request->filter_fullname)
                // ->where('parameters.group','=', 'Type')
                ->distinct()
                ->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if (request()->user()->can('punb_casestatus-edit')) {
                            // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                            $btn = '<a href="'. route('casestatus.edit', $row->APPREF ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                            return $btn;
                        }else{
    
                        };
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            else
            {
                // $data = DB::table('ld_ststrackingheader')
                // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                // ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
                // ->where('parameters.group','=', 'Type')
                // ->distinct()
                // ->get();
                $data =  DB::table('new_financing')
                // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
                // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
                // ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
                // ->where('FULLNAME', $request->filter_fullname)
                // ->where('parameters.group','=', 'Type')
                ->distinct()
                ->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if (request()->user()->can('punb_casestatus-edit')) {
                        // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                        // $btn = '<a href="'. route('casestatus.edit', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                        $btn = '<a href="'. route('casestatus.edit', $row->APPREF ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
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
        $cases = DB::table('ld_ststrackingheader')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->distinct()
        ->paginate(5);

        // view list in the dropdown menu for applicant
        // $applicant_list = DB::table('cf_custmaster')
        // ->join('ld_ststrackingheader','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->select('FULLNAME')
        // ->groupBy('FULLNAME')
        // ->distinct()
        // // ->get(['cf_custmaster.*']);
        // ->get();
        $applicant_list = DB::table('parameters')
        // ->join('ld_ststrackingheader','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->select('value_details','description')
        ->groupBy('value_details','description')
        ->where('group','=','type')
        ->distinct()
        // ->get(['cf_custmaster.*']);
        ->get();

        // view list in the dropdown menu for panel
        $panel_list = DB::table('collaborator')
        ->get();

        return view('maintenance.case_status.index',compact('cases','applicant_list','panel_list'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request) ;
        $input = $request->all();
        $list = $input['case_no'];
        $input['case_no'] = implode(',', $list);

        $case_exist = DB::table('ppsis_headers')
            ->where('case_no', '=', $input['case_no'])
            ->get();

            // dd(count($case_exist));
        if (count($case_exist)==0) {
            // return redirect()->back()->withErrors('Case No. already exist');

            $lastID = DB::table('ppsis_headers')
            // ->lastInsertId();
            // ->get();
            ->select('sis_id')
            ->latest()->first();

            // dd($lastID);
            $num_padded = sprintf("%010d",$lastID->sis_id+1);

            // dd($num_padded);
            $input['ref_no'] = $num_padded;
            Ppsis_Header::create($input);
            return redirect()->back()->with('success', 'Details created successfully.');

         }
         else{
            // $id = DB::getPdo()->lastInsertId();
            // Ppsis_Header::create($input);
            // return redirect()->back()->with('success', 'Details created successfully.');
            return redirect()->back()->withErrors('Case No. already exist');

         }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
       
         // view list in the table
         $listagreeno = DB::table('ld_ststrackingheader')
         ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
         ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
         ->select('ld_ststrackingheader.AGREEMENTNO')
         ->where('ID','=', $id )
         ->distinct()
         ->pluck('AGREEMENTNO')->first();

        

        $listagree = explode(',', $listagreeno);


         // view list in the table
         $world = DB::table('ld_ststrackingheader')
         ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
         ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
         ->where('ID','=', $id )
         ->select('ID','PRDABBR')
         ->distinct()
         ->get();

        //  dd($world);
        

        return view('maintenance.case_status.create', compact('listagreeno','listagree','world'));
        // return view('maintenance.case_status.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         // header details
         $casesheader = DB::table('ld_ststrackingheader')
         ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
         ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
         ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
         ->where('parameters.group','=', 'Type')
         ->where('ld_ststrackingheader.ID','=', $id )
         ->distinct()
         ->first();
        //  ->find($id);

         // body details
         $cases = DB::table('ppsis_headers')
         ->selectRaw('*, ' . $this->dateFormatQuery([
             'ppsis_headers', 'updated_at'
         ])) 
         ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'ppsis_headers.header_id')
         ->join('parameters AS p','ppsis_headers.status', '=', 'p.param_value')
         ->where('ld_ststrackingheader.ID','=', $id )
         ->where('p.group','=', 'case_status' )
         ->distinct()
         ->get();

         return view('maintenance.case_status.edit',compact('casesheader','cases'));
        //  ->with('i', (request()->input('page', 1) - 1) * 5);
          
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
        // dd($request);
        $request->validate([
            'sis_id' => 'required',
            'header_id' => 'required',
            'app_type' => 'required',
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

        if($request->app_type == 'STL'){

            $financing = PunbFinancing::create($request->all());
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

            $commenthead = DB::table('financings')
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
        }elseif ($request->app_type == 'RST'){

            $financing = PunbRestructure::create($request->all());
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

            $commenthead = DB::table('restructures')
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
        }elseif ($request->app_type == 'RIN'){
            $financing = PunbReinstate::create($request->all());
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
            $commenthead = DB::table('reinstates')
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
        }elseif ($request->app_type == 'VLO'){
            $financing = PunbVLO::create($request->all());
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
            $commenthead = DB::table('restructures')
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
        }
        // $commenthead = DB::table('financings')
        // ->where('sis_id', '=' , $id);
        // $commenthead->sis_id = $request->get('sis_id');
        // $commenthead->header_id = $request->get('header_id');
        // $commenthead->status_case = $closed;
        // $commenthead->user_lastmaintain = $request->get('user_lastmaintain');
        
        // $commenthead->update([
        //     // 'sis_id' => $request->sis_id,
        //     // 'header_id' => $request->header_id,
        //     'status_case' => $closed,
        //     'user_lastmaintain' => $request->user_lastmaintain
        // ]);

       
        //update table header
        $sishead = DB::table('ppsis_headers')
        ->where('sis_id', '=' , $id);

        $closes = "0";
       
        
        $sishead->update([
            // 'header_id' => $request->header_id,
            'status' => $closes,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        // return redirect()->route('maintenance.case_status.viewcase', $request->sis_id)
        return redirect()->back()
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

    public function ViewCases($id)
    {
        // header details
        $financings = DB::table('ld_ststrackingheader')
        ->select('*', 'p.value_details AS case_status', 'parameters.description AS app_type')
        ->join('ppsis_headers', 'ppsis_headers.header_id','=','ld_ststrackingheader.ID')
        ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        ->join('parameters','parameters.value_details', '=', 'ld_ststrackingheader.TYPE')
        ->join('parameters AS p','ppsis_headers.status', '=', 'p.param_value')
        // ->where('ld_ststrackingheader.TYPE','=','STL')
        ->where('ppsis_headers.sis_id','=',$id)
        ->where('p.group','=','case_status')
        ->first();

        // dd($financings);

        // status close case
        // $statuscase = DB::table('financings')
        // ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'financings.header_id')
        // ->join('ppsis_headers', 'ppsis_headers.header_id','=','ld_ststrackingheader.ID')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->select('status_case')
        // ->where('TYPE','=','STL')
        // ->where('ppsis_headers.status','=','0')
        // ->where('ppsis_headers.sis_id','=',$id)
        // ->groupby('status_case')
        // ->distinct()
        // ->get();
        $statuscase = DB::table('ppsis_headers')
        // ->join('ld_ststrackingheader','ld_ststrackingheader.ID', '=', 'financings.header_id')
        // ->join('ppsis_headers', 'ppsis_headers.header_id','=','ld_ststrackingheader.ID')
        // ->join('cf_custmaster','cf_custmaster.CUSTNO', '=', 'ld_ststrackingheader.CUSTNO')
        // ->join('collaborator','collaborator.ICode', '=', 'ld_ststrackingheader.PANELSOLICITOR')
        // ->select('status_case')
        ->select('status')
        // ->where('TYPE','=','STL')
        ->where('ppsis_headers.status','=','0')
        ->where('ppsis_headers.sis_id','=',$id)
        ->groupby('status')
        ->distinct()
        ->get();

        $current_time = Carbon::now();

        return view('maintenance.case_status.viewcase',compact('financings','statuscase','current_time'));
    }

    public function ReopenCase(Request $request, $id)
    {
        $request->validate([
            'sis_id' => 'required',
            'header_id' => 'required',
            'user_lastmaintain' => 'required',
        ]);
        //update table financing
        $reopened = "Re-Opened";

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
        
        // $commenthead = DB::table('financings')
        // ->where('sis_id', '=' , $id);
        // $commenthead->sis_id = $request->get('sis_id');
        // $commenthead->header_id = $request->get('header_id');
        // $commenthead->status_case = $reopened;
        // $commenthead->user_lastmaintain = $request->get('user_lastmaintain');

        if($request->app_type == 'STL'){

            $financing = PunbFinancing::create($request->all());
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

            $commenthead = DB::table('financings')
            ->where('sis_id', '=' , $id);
            $commenthead->sis_id = $request->get('sis_id');
            $commenthead->header_id = $request->get('header_id');
            $commenthead->status_case = $reopened;
            $commenthead->user_lastmaintain = $request->get('user_lastmaintain');

            $commenthead->update([
                // 'sis_id' => $request->sis_id,
                // 'header_id' => $request->header_id,
                'status_case' => $reopened,
                'user_lastmaintain' => $request->user_lastmaintain
            ]);
        }elseif ($request->app_type == 'RST'){

            $financing = PunbRestructure::create($request->all());
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


            $commenthead = DB::table('restructures')
            ->where('sis_id', '=' , $id);
            $commenthead->sis_id = $request->get('sis_id');
            $commenthead->header_id = $request->get('header_id');
            $commenthead->status_case = $reopened;
            $commenthead->user_lastmaintain = $request->get('user_lastmaintain');

            $commenthead->update([
                // 'sis_id' => $request->sis_id,
                // 'header_id' => $request->header_id,
                'status_case' => $reopened,
                'user_lastmaintain' => $request->user_lastmaintain
            ]);
        }elseif ($request->app_type == 'RIN'){
            $financing = PunbReinstate::create($request->all());
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

            $commenthead = DB::table('reinstates')
            ->where('sis_id', '=' , $id);
            $commenthead->sis_id = $request->get('sis_id');
            $commenthead->header_id = $request->get('header_id');
            $commenthead->status_case = $reopened;
            $commenthead->user_lastmaintain = $request->get('user_lastmaintain');

            $commenthead->update([
                // 'sis_id' => $request->sis_id,
                // 'header_id' => $request->header_id,
                'status_case' => $reopened,
                'user_lastmaintain' => $request->user_lastmaintain
            ]);
        }elseif ($request->app_type == 'VLO'){

            $financing = PunbVLO::create($request->all());
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

            $commenthead = DB::table('vlos')
            ->where('sis_id', '=' , $id);
            $commenthead->sis_id = $request->get('sis_id');
            $commenthead->header_id = $request->get('header_id');
            $commenthead->status_case = $reopened;
            $commenthead->user_lastmaintain = $request->get('user_lastmaintain');

            $commenthead->update([
                // 'sis_id' => $request->sis_id,
                // 'header_id' => $request->header_id,
                'status_case' => $reopened,
                'user_lastmaintain' => $request->user_lastmaintain
            ]);
        }

        
        // $commenthead->update([
        //     // 'sis_id' => $request->sis_id,
        //     // 'header_id' => $request->header_id,
        //     'status_case' => $reopened,
        //     'user_lastmaintain' => $request->user_lastmaintain
        // ]);

       
        //update table header
        $sishead = DB::table('ppsis_headers')
        ->where('sis_id', '=' , $id);

        $reopen = "3";
       
        
        $sishead->update([
            // 'header_id' => $request->header_id,
            'status' => $reopen,
            'user_lastmaintain' => $request->user_lastmaintain
        ]);

        // return redirect()->route('maintenance.case_status.viewcase', $request->sis_id)
        return redirect()->back()
        ->with('success', 'Details Update successfully.');
    }
}
