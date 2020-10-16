<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('webinars', function(Blueprint $table) {
           $table->increments('id');
           $table->text('name')->nullable();
           $table->text('description')->nullable();
           $table->text('webinar_link')->nullable();
           $table->time('start_at')->nullable();
           $table->time('finish_at')->nullable();
           $table->date('date')->nullable();
           $table->integer('hours')->nullable();
           $table->integer('room_id')->nullable();
           $table->text('record_link')->nullable();
           $table->integer('metodist')->nullable();
           $table->timestamps();
        });
        
        Schema::create('webinars2teachers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('webinar_id')->nullable();
            $table->integer('contract_id')->nullable();
            
        });
        
        Schema::create('webinars2groups', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->nullable();
            $table->integer('webinar_id')->nullable();
            $table->integer('metodist')->nullable();
            
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
