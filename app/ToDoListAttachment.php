<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoListAttachment extends Model
{
    protected $fillable = ['to_do_list_id', 'user_id', 'file'];
    protected $hidden = ['created_at', 'updated_at', 'user_id'];

    public function user()
    {
        return $this->hasOne(UserWithHiddenFields::class, 'id', 'user_id');
    }
}
