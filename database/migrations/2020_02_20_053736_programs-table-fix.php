<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProgramsTableFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
     Schema::table('programs', function($table){
            $table->string('description')->nullable()->change();
            $table->integer('hours')->nullable()->change();
            $table->integer('form_id')->nullable()->change();
            $table->integer('active')->nullable()->change();
            $table->integer('attestation_id')->nullable()->change();
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
