<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Roles as ModelRoles;

class RoleTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        if (isset($user->id) && $user->id == 1) {
            $model = ModelRoles::find(1);
            if (!$model) {
                $model = new ModelRoles();
            }
            $model->user_id = 1;
            $model->role = 'admin';
            $model->save();
        }
    }
}
