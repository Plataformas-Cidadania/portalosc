<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbPesoBarraTransparenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_peso_barra_transparencia', function(Blueprint $table)
		{
			$table->integer('id_peso_barra_transparencia', true);
			$table->text('nome_secao');
			$table->float('peso_secao', 10, 0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_peso_barra_transparencia');
	}

}
