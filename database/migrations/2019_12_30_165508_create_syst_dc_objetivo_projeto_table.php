<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcObjetivoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_objetivo_projeto', function(Blueprint $table)
		{
			$table->integer('cd_objetivo_projeto', true)->comment('Código do objetivo do projeto');
			$table->text('tx_nome_objetivo_projeto')->comment('Nome do objetivo do projeto');
			$table->text('tx_codigo_objetivo_projeto')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_objetivo_projeto');
	}

}
