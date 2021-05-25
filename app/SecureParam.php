<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecureParam extends Model
{
    protected $table = 'parameters';
    
    protected $fillable = [
        'group', 
        'param_value',
        'value_details',
        'description',
        'user_lastmaintain',
    ];
    
}
