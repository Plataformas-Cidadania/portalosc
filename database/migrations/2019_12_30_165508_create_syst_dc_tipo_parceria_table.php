<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcTipoParceriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_tipo_parceria', function(Blueprint $table)
		{
			$table->integer('cd_tipo_parceria', true)->comment('Código do tipo de parceria');
			$table->text('tx_nome_tipo_parceria')->comment('Nome do tipo de parceria');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_tipo_parceria');
	}

}
