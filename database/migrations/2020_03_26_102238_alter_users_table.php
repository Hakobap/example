<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_id')->after('phone')->nullable();
            $table->string('city')->after('country_id')->nullable();
            $table->string('address')->after('city')->nullable();
            $table->string('post_code')->after('address')->nullable();
            $table->string('photo')->after('post_code')->nullable();
            $table->tinyInteger('gender')->after('last_name')->default(0);
            $table->date('date_of_birth')->after('gender')->nullable();
            $table->date('hired_date')->after('date_of_birth')->nullable();
            $table->string('emergency_control_name')->after('hired_date')->nullable();
            $table->string('emergency_phone')->after('emergency_control_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['country_id', 'city', 'address', 'post_code', 'photo', 'gender', 'date_of_birth', 'hired_date', 'emergency_control_name', 'emergency_phone']);
        });
    }
}
