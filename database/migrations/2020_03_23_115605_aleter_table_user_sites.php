<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AleterTableUserSites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_sites', function (Blueprint $table) {
            $table->bigInteger('country_id')->after('id')->unsigned()->nullable();
            $table->string('city')->after('country_id')->nullable();
            $table->string('address')->after('city')->nullable();
            $table->string('postcode')->after('address')->nullable();
            $table->string('state')->after('postcode')->nullable();
            $table->string('phone')->after('state')->nullable();
            //$table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
