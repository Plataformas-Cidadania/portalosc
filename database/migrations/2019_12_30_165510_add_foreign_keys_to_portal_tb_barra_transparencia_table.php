<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPortaltbBarraTransparenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('portal.tb_barra_transparencia', function(Blueprint $table)
		{
			$table->foreign('id_osc', 'fk_barra_transparencia')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('portal.tb_barra_transparencia', function(Blueprint $table)
		{
			$table->dropForeign('fk_barra_transparencia');
		});
	}

}
