<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbLocalizacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_localizacao', function(Blueprint $table)
		{
			$table->foreign('cd_fonte_geocodificacao', 'fk_cd_fonte_geocodificacao')->references('cd_fonte_geocodoficacao')->on('syst.dc_fonte_geocodificacao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_osc', 'fk_id_osc')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_localizacao', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_fonte_geocodificacao');
			$table->dropForeign('fk_id_osc');
		});
	}

}
