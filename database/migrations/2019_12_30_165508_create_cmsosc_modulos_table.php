<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscmodulosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.modulos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem')->nullable();
			$table->string('titulo')->nullable();
			$table->text('descricao')->nullable();
			$table->text('arquivo')->nullable();
			$table->text('slug')->nullable();
			$table->integer('tipo_id');
			$table->integer('cmsuser_id');
			$table->timestamps();
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
		Schema::drop('cmsosc.modulos');
	}

}
