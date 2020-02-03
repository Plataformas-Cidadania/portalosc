<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogtbLogCargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log.tb_log_carga', function(Blueprint $table)
		{
			$table->integer('id_carga', true);
			$table->text('tx_carga');
			$table->dateTime('dt_inicio');
			$table->dateTime('dt_fim')->nullable();
			$table->integer('cd_status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log.tb_log_carga');
	}

}
