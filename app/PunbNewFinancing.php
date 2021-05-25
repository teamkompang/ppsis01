<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PunbNewFinancing extends Model
{
    protected $primaryKey = 'cid';

    protected $table = 'nf_financings';

    protected $fillable = [
            'sis_id',
            'header_id',
			'panel_update',
			'pic',
			'details',
			'status_comment',
			'status_case',
			'issue_date',
			'return_date',
			'update_date',
			'user_lastmaintain',
    ];
}
