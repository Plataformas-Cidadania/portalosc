<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcFonteDadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_fonte_dados', function(Blueprint $table)
		{
			$table->text('cd_sigla_fonte_dados')->primary('pk_dc_fonte_dados')->comment('Código Fonte de Dados');
			$table->text('tx_nome_fonte_dados')->comment('Nome da Fonte de Dados');
			$table->text('tx_descricao_fonte_dados')->nullable()->comment('Descrição da Fonte de Dados');
			$table->text('tx_referencia_fonte_dados')->nullable()->comment('Referência da Fonte de Dados');
			$table->integer('nr_prioridade')->default(99);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_fonte_dados');
	}

}
