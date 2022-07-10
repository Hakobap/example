<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePassword extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password'
    ];

    private $rules = [
        'old_password' => 'required',
        'password' => 'required|required_with:password_confirmation|confirmed',
        'password_confirmation' => 'required|min:8'
    ];

    /**
     * @param $data
     * @return Validator
     */
    public function validation($data)
    {
        $validator = Validator::make($data->all(), $this->rules);

        // Optionally customize this version using new ->after()
        $validator->after(function() use ($validator, $data) {
            // Do more validation
            if($data->old_password && Hash::check($data->old_password, $this->user->password) == false) {
                // Password is not matching
                $validator->errors()->add('old_password', 'The old password no exist');
            }
        });

        $validator->validate();

        return $validator;
    }


    public function change(\Illuminate\Validation\Validator $validator, $data)
    {
        if(!$validator->fails()) {
            $this->user->password = bcrypt($data->password);
            $this->user->save();
            $data->session()->flash('alert-success', 'Password was successful changed!');
            return true;
        }

    }
}