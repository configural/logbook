<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HoursFloat1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('disciplines', function(Blueprint $table){
        $table->float('hours')->default(0)->change();});
        
        Schema::table('programs', function(Blueprint $table){
        $table->float('hours')->default(0)->change();});
    
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
