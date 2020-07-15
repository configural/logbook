<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Journalrasp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('journal', function(Blueprint $table){
            $table->integer('rasp_id')->nullable();
            $table->dropcolumn('timetable_id');
            $table->dropcolumn('l_hours');
            $table->dropcolumn('p_hours');
            
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
