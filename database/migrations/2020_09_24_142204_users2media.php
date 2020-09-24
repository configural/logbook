<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users2media extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('media2users', function(Blueprint $table){
            
            $table->increments('id');
            $table->integer('media_id')->nullable();
            $table->integer('user_id')->nullable();
            
            
        });
        
        Schema::table('mediacontent', function(Blueprint $table){
            $table->dropColumn('user_id');
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
