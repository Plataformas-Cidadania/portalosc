<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbAreaAtuacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_area_atuacao', function(Blueprint $table)
		{
			$table->integer('id_area_atuacao', true)->comment('Identificador da área de atuação fasfil');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->integer('cd_area_atuacao')->comment('Código da área de atuação');
			$table->integer('cd_subarea_atuacao')->nullable()->comment('Código da subárea de atuação');
			$table->text('ft_area_atuacao')->nullable()->comment('Fonte da área de atuação');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->text('tx_nome_outra')->nullable();
			$table->unique(['id_area_atuacao','id_osc','cd_area_atuacao','cd_subarea_atuacao'], 'ix_tb_area_atuacao');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_area_atuacao');
	}

}
