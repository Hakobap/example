<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name']);
            $table->bigInteger('parent_id')->nullable()->after('id');
            $table->string('first_name')->after('parent_id');
            $table->string('last_name')->after('first_name');
            $table->string('company')->after('last_name');
            $table->string('roster_start_time')->after('company');
            $table->string('phone')->after('email');
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
            $table->string('name');
            $table->dropColumn(['first_name', 'last_name', 'company', 'roster_start_time', 'phone']);
        });
    }
}
