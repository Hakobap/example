<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientImage extends Model
{
    protected  $fillable = [
        'image', 'sort', 'url'
    ];
}
