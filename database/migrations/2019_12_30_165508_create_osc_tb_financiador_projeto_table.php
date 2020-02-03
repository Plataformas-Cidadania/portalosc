<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbFinanciadorProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_financiador_projeto', function(Blueprint $table)
		{
			$table->integer('id_financiador_projeto', true)->comment('Identificador do financiador do projeto');
			$table->integer('id_projeto')->nullable()->comment('Identificador do projeto');
			$table->text('tx_nome_financiador')->comment('Nome do financiador');
			$table->text('ft_nome_financiador')->nullable()->comment('Fonte nome do financiador');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->unique(['id_financiador_projeto','id_projeto'], 'ix_tb_financiador_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_financiador_projeto');
	}

}
