<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
        
        
        Schema::table('users', function(Blueprint $table){
            $table->integer('role_id')->default(1);
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
        Schema::drop('roles');
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('role_id');
        });
    }
}
