<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbLocalizacaoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_localizacao_projeto', function(Blueprint $table)
		{
			$table->integer('id_localizacao_projeto', true)->comment('Identificador da localização do projeto');
			$table->integer('id_projeto')->nullable();
			$table->integer('id_regiao_localizacao_projeto')->nullable()->comment('Identificador da região da localização do projeto');
			$table->text('ft_regiao_localizacao_projeto')->nullable()->comment('Fonte região da localização do projeto');
			$table->text('tx_nome_regiao_localizacao_projeto')->nullable()->comment('Nome da região da localização do projeto');
			$table->text('ft_nome_regiao_localizacao_projeto')->nullable()->comment('Fonte nome região licalização do projeto');
			$table->boolean('bo_localizacao_prioritaria')->nullable()->comment('Localização onde o projeto é prioritariamente executado?');
			$table->text('ft_localizacao_prioritaria')->nullable()->comment('Fonte que informa se a lozalização é prioritaria');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->unique(['id_localizacao_projeto','id_projeto'], 'ix_tb_localizacao_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_localizacao_projeto');
	}

}
