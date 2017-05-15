<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('participant_id');
			$table->string('type')->nullable();
			$table->string('url')->nullable();
	        $table->string('title')->nullable();	        
			$table->string('file_name')->nullable();
	        $table->string('attribute')->nullable();
	        $table->integer('count')->nullable();			
         	$table->boolean('status')->default(1);
	        $table->softDeletes();
	        $table->nullableTimestamps();            
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}
