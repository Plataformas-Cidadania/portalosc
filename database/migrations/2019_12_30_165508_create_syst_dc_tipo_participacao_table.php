<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcTipoParticipacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_tipo_participacao', function(Blueprint $table)
		{
			$table->integer('cd_tipo_participacao', true)->comment('Código do tipo de participação');
			$table->string('tx_nome_tipo_participacao', 30)->comment('Nome do tipo de participação');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_tipo_participacao');
	}

}
