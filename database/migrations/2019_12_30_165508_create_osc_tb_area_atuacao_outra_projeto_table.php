<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbAreaAtuacaoOutraProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_area_atuacao_outra_projeto', function(Blueprint $table)
		{
			$table->integer('id_area_atuacao_outra_projeto', true)->comment('Identificador da tabela de outra área de atuação do projeto');
			$table->integer('id_projeto')->comment('Identificador do projeto');
			$table->integer('id_area_atuacao_outra')->comment('Identificador da outra área de atuação');
			$table->text('ft_area_atuacao_outra_projeto')->nullable()->comment('Fonte da outra área de atuação');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_area_atuacao_outra_projeto');
	}

}
