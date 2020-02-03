<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscnoticiasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.noticias', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo');
			$table->text('descricao');
			$table->text('arquivo');
			$table->integer('cmsuser_id');
			$table->timestamps();
			$table->date('data')->nullable();
			$table->text('resumida')->default('');
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
		Schema::drop('cmsosc.noticias');
	}

}
