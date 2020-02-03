<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcClasseAtividadeEconomicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_classe_atividade_economica', function(Blueprint $table)
		{
			$table->string('cd_classe_atividade_economica', 10)->primary('pk_dc_classe_atividade_economica')->comment('Código da atividade economica');
			$table->text('tx_nome_classe_atividade_economica')->comment('Nome da classe da atividade economica');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_classe_atividade_economica');
	}

}
