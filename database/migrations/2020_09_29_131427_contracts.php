<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        Schema::create('contracts', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->date('start_at')->nullable();
            $table->date('finish_at')->nullable();
            $table->integer('active')->default(1);
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
        //
    }
}
