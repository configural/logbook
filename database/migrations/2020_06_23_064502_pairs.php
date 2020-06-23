<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pairs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pairs', function(Blueprint $table){
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('variant0')->nullable();
            $table->string('variant1')->nullable();
            $table->string('variant2')->nullable();
            $table->string('variant3')->nullable();
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
