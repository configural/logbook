<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Regions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('taxoffice', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->integer('is_mri')->nullable();
            $table->integer('number')->nullable();
            $table->text('address')->nullable();
            $table->integer('position')->nullable();
            $table->integer('district_id')->nullable();
        });

        Schema::create('division', function(Blueprint $table){
            $table->increments('id');
            $table->integer('taxoffice_id')->nullable();
            $table->string('name');
        });

        Schema::create('district', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->integer('webinartime_id')->nullable();
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
