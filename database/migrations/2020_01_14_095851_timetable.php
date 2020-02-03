<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Timetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('timetable', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('teacher_id');
            $table->integer('change_teacher_id');
            $table->integer('block_id');
            $table->integer('room_id');
            $table->dateTime('start_at');
            $table->integer('hours');
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
        Schema::dropIfExists('timetable');
    }
}
