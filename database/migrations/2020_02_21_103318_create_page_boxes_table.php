<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_boxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->default(1)->unsigned();
            $table->foreign('category_id')->references('id')->on('page_boxes')->onDelete('cascade');
            $table->string('page')->default('home')->nullable();
            $table->string('type')->default('banner')->nullable();
            $table->string('title')->nullable();
            $table->longText('text')->nullable();
            $table->string('file')->nullable();
            $table->longText('extra')->nullable();
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
        Schema::dropIfExists('page_boxes');
    }
}
