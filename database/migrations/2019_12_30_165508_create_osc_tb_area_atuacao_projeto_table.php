<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbAreaAtuacaoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_area_atuacao_projeto', function(Blueprint $table)
		{
			$table->integer('id_area_atuacao_projeto', true)->comment('Identificador da área de atuação do projeto');
			$table->integer('id_projeto')->comment('Identificador do projeto');
			$table->integer('cd_subarea_atuacao')->comment('Código da subárea de atuação');
			$table->text('ft_area_atuacao_projeto')->nullable()->comment('Fonte da área de atuação');
			$table->boolean('bo_oficial')->comment('Registro vindo de base oficial');
			$table->unique(['id_area_atuacao_projeto','id_projeto','cd_subarea_atuacao'], 'ix_tb_area_atuacao_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_area_atuacao_projeto');
	}

}
