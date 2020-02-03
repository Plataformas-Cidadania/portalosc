<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbAreaAtuacaoOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_area_atuacao_outra', function(Blueprint $table)
		{
			$table->integer('id_area_atuacao_outra', true)->comment('Identificador da área de atuação da OSC');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->integer('id_area_atuacao_declarada')->nullable()->comment('Chave estrangeira para a área de atuação declarada pela OSC');
			$table->text('ft_area_atuacao_outra')->nullable()->comment('Fonte da área declarada');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_area_atuacao_outra');
	}

}
