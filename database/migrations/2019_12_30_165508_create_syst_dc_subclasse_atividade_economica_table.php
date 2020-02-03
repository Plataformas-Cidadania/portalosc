<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcSubclasseAtividadeEconomicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_subclasse_atividade_economica', function(Blueprint $table)
		{
			$table->decimal('cd_subclasse_atividade_economica', 7, 0)->primary('pk_cd_subclasse_atividade_economica')->comment('Código da Atividade Econômica');
			$table->string('cd_classe_atividade_economica', 10)->comment('Código da Atividade Economica com traço e barras');
			$table->text('tx_nome_subclasse_atividade_economica')->comment('Nome da subclasse da atividade economica');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_subclasse_atividade_economica');
	}

}
