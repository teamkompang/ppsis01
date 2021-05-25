<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class pre_reg extends Model
{
    use Notifiable;
    //

    protected $table = 'pre_reg';

    protected $fillable = [
         'email', 'company', 'role', 'status','received_email','access_expired','user_lastmaintain'
    ];
}
