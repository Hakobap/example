<?php

namespace App\Models;

use App\User;
use App\UserPosition;
use App\UserSite;
use Illuminate\Database\Eloquent\Model;

class EmployeeAction extends Model
{
    protected $visible = ['position'];

    protected $fillable = ['user_id', 'user_site_id', 'user_position_id'];


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function site()
    {
        return $this->hasOne(UserSite::class, 'id', 'user_site_id');
    }

    public function employeeTask()
    {
        return $this->hasOne(Task::class, 'employee_id', 'user_id');
    }

    public function position()
    {
        return $this->hasOne(UserPosition::class, 'id', 'user_position_id');
    }

    public static function getPositions($uid, $sid)
    {
        return self::with('position')->where(['user_id' => intval($uid), 'user_site_id' => intval($sid)])->get();
    }
}
