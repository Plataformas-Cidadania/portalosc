<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscequipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.equipes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem')->nullable();
			$table->string('titulo')->nullable();
			$table->string('sub_titulo')->nullable();
			$table->text('descricao')->nullable();
			$table->text('arquivo')->nullable();
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
		Schema::drop('cmsosc.equipes');
	}

}
