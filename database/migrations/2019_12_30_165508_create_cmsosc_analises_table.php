<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscanalisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.analises', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo');
			$table->text('descricao');
			$table->text('arquivo');
			$table->date('data')->nullable();
			$table->integer('status')->default(0);
			$table->text('resumida')->default('');
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
		Schema::drop('cmsosc.analises');
	}

}
