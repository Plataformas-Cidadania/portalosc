<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLogtbLogCargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('log.tb_log_carga', function(Blueprint $table)
		{
			$table->foreign('cd_status', 'fk_cd_status')->references('cd_status')->on('syst.dc_status_carga')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('log.tb_log_carga', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_status');
		});
	}

}
