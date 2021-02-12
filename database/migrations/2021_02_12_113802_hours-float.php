<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HoursFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('blocks', function(Blueprint $table){
            $table->float('l_hours')->default(0)->change();
            $table->float('p_hours')->default(0)->change();
            $table->float('s_hours')->default(0)->change();
            $table->float('w_hours')->default(0)->change();
            
        });
        
        
    Schema::table('timetable', function(Blueprint $table){
        $table->float('hours')->default(0)->change();
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
