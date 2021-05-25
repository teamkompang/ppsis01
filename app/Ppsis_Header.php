<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ppsis_Header extends Model
{
    protected $table = 'ppsis_headers';
    protected $primaryKey  = 'sis_id';
    protected $foreignKey  = 'header_id';

    // $num = 4;
    //  $num_padded = sprintf("%010d", $primaryKey);
// echo $num_padded; // returns 04

    protected $fillable = [
        'sis_id',
        'ref_no',
        'header_id',
        'product',
        'case_no',
        'status',
        'user_created',
        'user_lastmaintain',];
}
