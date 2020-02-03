<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcZonaAtuacaoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_zona_atuacao_projeto', function(Blueprint $table)
		{
			$table->integer('cd_zona_atuacao_projeto', true)->comment('Código da zona de atuação');
			$table->text('tx_nome_zona_atuacao')->comment('Nome da zona de atução do projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_zona_atuacao_projeto');
	}

}
