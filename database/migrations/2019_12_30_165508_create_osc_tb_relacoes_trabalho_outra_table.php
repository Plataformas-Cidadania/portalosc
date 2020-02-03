<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbRelacoesTrabalhoOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_relacoes_trabalho_outra', function(Blueprint $table)
		{
			$table->integer('id_relacoes_trabalho_outra', true)->comment('Identificados da relação de trabalho outra');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->integer('nr_trabalhadores')->nullable()->comment('Número de trabalhadores');
			$table->text('ft_trabalhadores')->nullable()->comment('Fonte do número de trabalhadores');
			$table->text('tx_tipo_relacao_trabalho')->nullable()->comment('Tipo de relação de trabalho');
			$table->text('ft_tipo_relacao_trabalho')->nullable()->comment('Fonte do tipo da relação de trabalho');
			$table->unique(['id_relacoes_trabalho_outra','id_osc'], 'ix_tb_relacoes_trabalho_outra');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_relacoes_trabalho_outra');
	}

}
