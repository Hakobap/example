<?php

namespace App;

use App\Models\Country;
use App\Models\EmployeeAction;
use Illuminate\Database\Eloquent\Model;

class UserSite extends Model
{
    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at'];

    protected $fillable = ['user_id', 'value'];


    public function employeeActions()
    {
        return $this->belongsTo(EmployeeAction::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getFullAddress()
    {
        $address = '';

        if (isset($this->country->country_name)) {
            $address .= $this->country->country_name;
        }

        if ($this->city) {
            $address .= !$address ? $this->city : ', ' . $this->city;
        }

        if ($this->state) {
            $address .= !$address ? $this->state : ', ' . $this->state;
        }

        if ($this->address) {
            $address .= !$address ? $this->address : ', ' . $this->address;
        }

        return $address;
    }
}
