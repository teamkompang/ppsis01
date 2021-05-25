<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function formatDate($date)
    {
        return $date ? with(new Carbon($date))->format('d/m/Y') : '';
    }

    public function dateFormatQuery($column = [])
    {
        // dd('DATE_FORMAT(' . $column[0] . '.' . $column[1] . ', "%d/%m/%Y") AS ' . $column[1]);
        return 'DATE_FORMAT(' . $column[0] . '.' . $column[1] . ', "%d/%m/%Y") AS ' . $column[1];
    }
}
