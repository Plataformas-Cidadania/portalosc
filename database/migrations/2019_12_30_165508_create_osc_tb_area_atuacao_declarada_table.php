<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbAreaAtuacaoDeclaradaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_area_atuacao_declarada', function(Blueprint $table)
		{
			$table->integer('id_area_atuacao_declarada', true)->comment('Identificador da área de atuação declarada');
			$table->text('tx_nome_area_atuacao_declarada')->comment('Nome da área de atuação declarada');
			$table->text('ft_nome_area_atuacao_declarada')->nullable()->comment('Fonte do nome da área de atuação declarada');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_area_atuacao_declarada');
	}

}
