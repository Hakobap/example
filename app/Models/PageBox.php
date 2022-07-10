<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBox extends Model
{
    CONST BANER = ['page' => 'home', 'type' => 'banner', 'category_id' => 1];
    CONST HOME_HOW_IT_WORK = ['page' => 'home', 'type' => 'how-it-works', 'category_id' => 1];
    CONST INVESTMENT = ['page' => 'home', 'type' => 'investment', 'category_id' => 1];

    protected $fillable = [

    ];
}
