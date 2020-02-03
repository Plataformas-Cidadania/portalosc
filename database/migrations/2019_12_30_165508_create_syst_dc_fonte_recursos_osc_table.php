<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcFonteRecursosOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_fonte_recursos_osc', function(Blueprint $table)
		{
			$table->integer('cd_fonte_recursos_osc', true)->comment('Código de identificador da fonte de recursos da OSC');
			$table->integer('cd_origem_fonte_recursos_osc')->comment('Código da origem da fonte de recursos da OSC');
			$table->text('tx_nome_fonte_recursos_osc')->comment('Nome da fonte de recursos da OSC');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_fonte_recursos_osc');
	}

}
