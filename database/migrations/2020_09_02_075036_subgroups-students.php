<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubgroupsStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('students', function(Blueprint $table){
            $table->integer('subgroup')->default(1);
        });
        
        Schema::table('groups', function(Blueprint $table) {
            $table->integer('subgroup_count')->default(1);
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
