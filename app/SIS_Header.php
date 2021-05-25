<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SIS_Header extends Model
{
    protected $table = 'sis_headers';
    protected $primaryKey  = 'sis_id';
    protected $foreignKey  = 'header_id';
    
    protected $fillable = [
        'sis_id',
        'header_id',
        'product',
        'case_no',
        'status',
        'user_lastmaintain',];
}
