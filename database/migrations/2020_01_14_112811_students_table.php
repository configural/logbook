<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('students', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('secname');
            $table->string('name');
            $table->string('fathername');
            $table->string('sono');
            $table->string('qualification');
            $table->string('edu_level');
            $table->string('doc_seria');
            $table->string('doc_number');
            $table->string('doc_secname');
            $table->integer('status');
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
        Schema::dropIfExists('students');
    }
}
