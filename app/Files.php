<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table='files';
    protected $fillable = [
        'sis_id', 
        'header_id', 
        'panel_update', 
        'pic', 
        'name',
        'description',
        'path',
        'user_created',
        'user_lastmaintain',
    ];
}
