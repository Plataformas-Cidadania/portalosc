<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcSubareaAtuacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_subarea_atuacao', function(Blueprint $table)
		{
			$table->integer('cd_subarea_atuacao', true)->comment('Código de identificação da subárea de atuação');
			$table->text('tx_nome_subarea_atuacao')->comment('Nome da subárea de atuação');
			$table->integer('cd_area_atuacao')->comment('Código da área de atuação');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_subarea_atuacao');
	}

}
