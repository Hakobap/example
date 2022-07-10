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
            $table->tinyInteger('invited')->after('parent_id')->default(0)->nullable()->comment('is employee invited');
            $table->integer('PIN')->default(0000)->nullable()->after('remember_token')->nullable();
            $table->string('invite_key')->after('PIN')->nullable();
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
            $table->dropColumn(['invited', 'invite_key']);
        });
    }
}
