<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkloadChangeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('change_log', function(Blueprint $table){
            
            $table->increments('id');
            $table->timestamps();
            $table->string('table_name')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('method')->nullable();
            
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
