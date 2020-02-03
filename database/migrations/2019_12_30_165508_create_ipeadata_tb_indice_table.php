<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIpeadatatbIndiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ipeadata.tb_indice', function(Blueprint $table)
		{
			$table->integer('cd_indice', true)->comment('CÃ³digo do indice do IpeaData no MapaOSC');
			$table->text('tx_nome_indice')->comment('Nome do Indice do IPEAData');
			$table->text('tx_sigla')->comment('Sigla do Indice do IPEAData');
			$table->text('tx_tema')->comment('Tema do Indice do IPEAData');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ipeadata.tb_indice');
	}

}
