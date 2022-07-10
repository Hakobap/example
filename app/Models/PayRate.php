<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayRate extends Model
{
    protected $fillable = ['user_id', 'value1', 'value2', 'value3', 'value4', 'value5', 'value6', 'value7', 'public_holidays'];
}
