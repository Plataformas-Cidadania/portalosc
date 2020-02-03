<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscvideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.videos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('titulo')->nullable();
			$table->string('link_video')->nullable();
			$table->integer('cmsuser_id');
			$table->timestamps();
			$table->date('data')->nullable();
			$table->text('resumida')->default('');
			$table->text('descricao')->default('');
			$table->string('imagem')->default('');
			$table->integer('status')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cmsosc.videos');
	}

}
