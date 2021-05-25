<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailCase extends Model
{
    protected $table='email_cases';
    protected $fillable = [
            'id',
            'sis_id',
            'ref_no',
            'header_id',
            'cid',
            'details',
            'status_case',
            'company_sender',
            'person_sender',
            'company_receiver',
            'person_receiver',
            'status_email',
            'user_lastmaintain',
    ];
}
