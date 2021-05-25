<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter_Category extends Model
{
    protected $table = 'param_category';

    protected $fillable = [
        'category_code', 'description',
    ];
}
