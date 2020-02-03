<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsosceditaisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.editais', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo');
			$table->string('instituicao')->nullable();
			$table->string('area')->nullable();
			$table->date('data_vencimento');
			$table->string('numero_chamada')->nullable();
			$table->string('edital')->nullable();
			$table->string('status')->nullable();
			$table->string('arquivo');
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
		Schema::drop('cmsosc.editais');
	}

}
