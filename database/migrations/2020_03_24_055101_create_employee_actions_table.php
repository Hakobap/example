<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_actions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->unsigned();

            $table->bigInteger('user_site_id')->unsigned()->nullable();
            $table->foreign('user_site_id')->references('id')->on('user_sites')->onDelete('cascade')->unsigned();

            $table->bigInteger('user_position_id')->unsigned()->nullable();
            $table->foreign('user_position_id')->references('id')->on('user_positions')->onDelete('cascade')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_actions');
    }
}
