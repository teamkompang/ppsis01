<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailReg;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Invite;
use App\Mail\InviteCreated;
use App\pre_reg;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;



class MailRegController extends Controller
{
    function index()
    {
     return view('Email.tosendemailregister');
    }

    public function sendEmail(Request $request) {

        $user = pre_reg::where('email', '=', $request->email)->first();
        if ($user === null) {
            // user doesn't exist
            
            $this->validate($request, [ 
                'email'  =>  'required|email',
                'roles'  =>  'required',
                'company'  =>  'required',
                'status'  =>  'required',
                'access_expired'  =>  'required',
                'received_email'  =>  'required',
            ]);

            // validate the incoming request data
            do {
                //generate a random string using Laravel's str_random helper
                $token = Str::random(10);
            } //check if the token already exists and if it does, try again
            while (Invite::where('token', $token)->first());
        
            $email = $request->email;
            $role = $request->roles;
            $company = $request->company;
            $status = $request->status;
            $access_expired = $request->access_expired;
            $received_email = $request->received_email;

            $mailData = [
                'title' => 'Register Email',
                'url' => 'localhost/register',
                'token'  =>  $token,
                'email'  =>  $email,
                'role'  =>  $role,
                'company'  =>  $company,
                'status'  =>  $status,
                'access_expired'  =>  $access_expired,
                'received_email'  =>  $received_email,
            ];

            //create a new invite record
            $invite = Invite::create([
                'token'  =>  $token,
                'email'  =>  $email,
                'role'  =>  $role,
                'company'  =>  $company,
                'status'  =>  $status,
                'access_expired'  =>  $access_expired,
                'received_email'  =>  $received_email,
            ]);

            // $invite->assignRole($request->input('role'));

            Mail::to($email)->send(new EmailReg($invite), $invite->token);
            return back()->with('success', 'Success send email');
        }
        else{
            return back()->withError('errors', 'Error');
        }
    }

    public function accept($token)
    {
        // here we'll look up the user by the token sent provided in the URL
        // Look up the invite
        if (!$invite = Invite::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            abort(404);
        }
        
        // create the user with the details from the invite
        // $invites = pre_reg::create(['email' => $invite->email,
        //                             'role' => $invite->role,
        //                             'company' => $invite->company,
        //                             'status' => $invite->status,]);

        // delete the invite so it can't be used again
        $invite->update();

        // here you would probably log the user in and show them the dashboard, but we'll just prove it worked
        return view('auth.register', compact('invite'));
   
    }
}
