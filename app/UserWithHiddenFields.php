<?php

namespace App;

class UserWithHiddenFields extends User
{
    public $table = 'users';

    protected $visible = ['first_name', 'last_name'];

    protected $hidden = [];
}
