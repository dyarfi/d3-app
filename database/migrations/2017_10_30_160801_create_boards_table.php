<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('source');
            $table->string('subject')->nullable();            
            $table->text('description')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->default(1);
            $table->nullableTimestamps();
            $table->softDeletes();
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
