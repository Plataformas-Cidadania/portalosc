<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbRelacoesTrabalhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_relacoes_trabalho', function(Blueprint $table)
		{
			$table->integer('id_osc')->unique('ix_tb_relacoes_trabalho')->comment('Identificador da OSC');
			$table->integer('nr_trabalhadores_vinculo')->nullable()->comment('Número de trabalhadores com vínculo');
			$table->text('ft_trabalhadores_vinculo')->nullable()->comment('Fonte do número de trabalhadores com vínculo');
			$table->integer('nr_trabalhadores_deficiencia')->nullable()->comment('Número de trabalhadores portadores de deficiência');
			$table->text('ft_trabalhadores_deficiencia')->nullable()->comment('Fonte do número de trabalhadores portadores de deficiência');
			$table->integer('nr_trabalhadores_voluntarios')->nullable()->comment('Número de trabalhadores voluntários');
			$table->text('ft_trabalhadores_voluntarios')->nullable()->comment('Fonte do número de trabalhadores voluntários');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_relacoes_trabalho');
	}

}
