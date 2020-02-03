<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcConferenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_conferencia', function(Blueprint $table)
		{
			$table->integer('cd_conferencia', true)->comment('Código da conferência');
			$table->text('tx_nome_conferencia')->comment('Nome da conferência');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_conferencia');
	}

}
