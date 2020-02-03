<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcFonteGeocodificacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_fonte_geocodificacao', function(Blueprint $table)
		{
			$table->integer('cd_fonte_geocodoficacao', true)->comment('Código da fonte de geocodificação');
			$table->text('tx_fonte_geocodificacao')->nullable()->comment('Nome da fonte de geocodificação');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_fonte_geocodificacao');
	}

}
