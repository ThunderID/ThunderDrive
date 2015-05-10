<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('organization_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->integer('original_id')->unsigned()->nullable();
			$table->string('url');
			$table->string('title');
			$table->string('mime');
			$table->double('size');
			$table->double('width');
			$table->double('height');
			$table->string('file_key');
			$table->boolean('is_public');

			$table->timestamps();
			$table->softDeletes();

			$table->index('user_id');
			$table->index(['organization_id', 'category_id']);
			$table->index('category_id');
			$table->index('original_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('files');
	}

}
