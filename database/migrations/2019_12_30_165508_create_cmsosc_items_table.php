<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.items', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo');
			$table->text('descricao');
			$table->text('arquivo');
			$table->integer('modulo_id');
			$table->integer('cmsuser_id');
			$table->timestamps();
			$table->integer('posicao')->default(0);
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
		Schema::drop('cmsosc.items');
	}

}
