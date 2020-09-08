<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attestation2discipline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('disciplines', function(Blueprint $table) {
            $table->integer('attestation_id')->nullable();
            $table->integer('attestation_hours')->default(2);
        });
        
        Schema::table('programs', function(Blueprint $table){
            $table->integer('attestation_hours')->default(2);
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
