<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_actions', function (Blueprint $table) {
            $table->bigInteger('user_id')->after('id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_actions', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
}
