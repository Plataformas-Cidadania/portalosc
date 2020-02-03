<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbPublicoBeneficiadoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_publico_beneficiado_projeto', function(Blueprint $table)
		{
			$table->integer('id_projeto');
			$table->integer('id_publico_beneficiado_projeto', true);
			$table->text('ft_estimativa_pessoas_atendidas')->nullable();
			$table->integer('nr_estimativa_pessoas_atendidas')->nullable()->comment('Estimativa da quantidade de pessoas atendidas');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->text('tx_nome_publico_beneficiado')->nullable();
			$table->text('ft_nome_publico_beneficiado')->nullable();
			$table->unique(['id_projeto','id_publico_beneficiado_projeto'], 'ix_tb_publico_beneficiado_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_publico_beneficiado_projeto');
	}

}
