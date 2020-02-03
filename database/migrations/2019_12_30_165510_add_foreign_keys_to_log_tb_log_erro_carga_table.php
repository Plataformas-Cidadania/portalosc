<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLogtbLogErroCargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('log.tb_log_erro_carga', function(Blueprint $table)
		{
			$table->foreign('cd_status', 'fk_cd_status')->references('cd_status')->on('syst.dc_status_carga')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_carga', 'fk_id_carga')->references('id_carga')->on('log.tb_log_carga')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('log.tb_log_erro_carga', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_status');
			$table->dropForeign('fk_id_carga');
		});
	}

}
