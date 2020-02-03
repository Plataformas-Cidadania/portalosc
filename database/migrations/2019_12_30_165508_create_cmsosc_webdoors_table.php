<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscwebdoorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.webdoors', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo')->nullable();
			$table->text('descricao')->nullable();
			$table->text('link')->nullable();
			$table->integer('cmsuser_id');
			$table->timestamps();
			$table->integer('status')->default(0);
			$table->string('legenda')->nullable();
			$table->integer('posicao')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cmsosc.webdoors');
	}

}
