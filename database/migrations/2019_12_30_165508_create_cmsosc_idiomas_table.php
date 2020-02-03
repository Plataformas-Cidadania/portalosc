<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscidiomasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.idiomas', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo');
			$table->string('sigla');
			$table->integer('cmsuser_id');
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
		Schema::drop('cmsosc.idiomas');
	}

}
