<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcStatusCargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_status_carga', function(Blueprint $table)
		{
			$table->integer('cd_status', true)->comment('Código do status');
			$table->text('tx_nome_status')->comment('Nome do status');
			$table->text('tx_descricao_status')->comment('Descrição do status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_status_carga');
	}

}
