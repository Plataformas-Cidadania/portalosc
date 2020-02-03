<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSysttbTipoGraficoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.tb_tipo_grafico', function(Blueprint $table)
		{
			$table->integer('id_grafico', true);
			$table->text('nome_tipo_grafico')->nullable();
			$table->integer('status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.tb_tipo_grafico');
	}

}
