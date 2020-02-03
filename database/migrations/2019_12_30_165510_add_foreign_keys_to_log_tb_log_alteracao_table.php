<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLogtbLogAlteracaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('log.tb_log_alteracao', function(Blueprint $table)
		{
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
		Schema::table('log.tb_log_alteracao', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_carga');
		});
	}

}
