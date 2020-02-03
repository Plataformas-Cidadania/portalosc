<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcAreaAtuacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_area_atuacao', function(Blueprint $table)
		{
			$table->integer('cd_area_atuacao', true)->comment('Código da área de atuação');
			$table->text('tx_nome_area_atuacao')->comment('Nome da área de atuação');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_area_atuacao');
	}

}
