<?php

namespace App\Http\Controllers;

use App\PPSISEmailCase;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\PPSISCase;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;
use Auth;
use DataTables;

class PPSISEmailCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $email = DB::table('email_cases')
        // ->get();

       if ($request->ajax()) {
            $data =  DB::table('email_cases')
            ->select('*', 'c1.Name AS company_sender', 'c2.Name as company_receiver')
            ->join('parameters','parameters.param_value','email_cases.status_email')
            ->join('collaborator as c1','c1.ICode', '=', 'email_cases.company_sender')
            ->join('collaborator as c2','c2.ICode', '=', 'email_cases.company_receiver')
            ->where('parameters.group','Email_Status')
            // ->orderby('created_at')
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'" data-toggle="tooltip"  data-id="'.$row->ID.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-search"></i></a>';
                            // $btn = '<a href="'. route('punbfinancing.show', $row->ID ) .'"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>';
                            $btn = '';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('emailcases.index');
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
     * @param  \App\PPSISEmailCase  $pPSISEmailCase
     * @return \Illuminate\Http\Response
     */
    public function show(PPSISEmailCase $pPSISEmailCase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PPSISEmailCase  $pPSISEmailCase
     * @return \Illuminate\Http\Response
     */
    public function edit(PPSISEmailCase $pPSISEmailCase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PPSISEmailCase  $pPSISEmailCase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PPSISEmailCase $pPSISEmailCase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PPSISEmailCase  $pPSISEmailCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(PPSISEmailCase $pPSISEmailCase)
    {
        //
    }

    public function sendEmail() {

        $test = DB::table('email_cases')
                ->join('collaborator','collaborator.ICode', '=', 'email_cases.company_sender')
                ->where('status_email','0')
                ->distinct()
                ->get(); 

        $total = count($test);

            if(!empty($total)){
                foreach($test as $set){
                    // $email = $set->person_receiver;
                    $email = explode(',', $set->person_receiver);;
    
                    $mailData = [
                        'title' => 'Donotreply',
                        'url' => 'google.com',
                        'from' => $set->person_sender,
                        'company' => $set->Name,
                        'details' => $set->details,
                        'refno' => $set->ref_no,
                    ];
            
                    // dd($mailData);
    
                    Mail::to($email)->send(new PPSISCase($mailData));

                    $complete = "1";

                    // if(!empty(\auth::user()->name)){
                    //     $user_lastmaintain = \auth::user()->name;
                    // }
                    // else{
                    //     $user_lastmaintain = "System";
                    // }

                    $user_lastmaintain = "System";
                    
                    $commenthead = DB::table('email_cases')
                    ->where('status_email', '=' , '0')
                    ->where('sis_id',$set->sis_id)
                    ->where('id',$set->id);

                    $commenthead->update([
                        'status_email' => $complete,
                        'user_lastmaintain' => $user_lastmaintain,
                        'send_at' => Carbon::now()
                    ]);
                }

            }
            return redirect()->back()
            ->with('success', 'Details Update successfully.'); 
            // response()->json([
            //     'message' => 'Email has been sent.'
            // ], Response::HTTP_OK);
    }
}
