<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PPSISEmailCaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PPSISCase;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;
use Auth;

class NotifyCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:cases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To notify user cases thru email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
            return response()->json([
                'message' => 'Email has been sent.'
            ], Response::HTTP_OK);
    }
}
