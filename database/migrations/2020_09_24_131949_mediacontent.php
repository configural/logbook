<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mediacontent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mediacontent', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('user_id')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_finish')->nullable();
            $table->integer('status')->nullable();
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
