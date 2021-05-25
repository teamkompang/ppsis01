<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email', 'company', 'role', 'status','received_email','access_expired', 'token',
    ];
}
