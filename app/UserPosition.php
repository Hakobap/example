<?php

namespace App;

use App\Models\EmployeeAction;
use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    protected $fillable = ['user_id', 'value'];

    public function employeeActions()
    {
        return $this->belongsTo(EmployeeAction::class);
    }
}
