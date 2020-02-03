<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbAreaAtuacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_area_atuacao', function(Blueprint $table)
		{
			$table->foreign('cd_area_atuacao', 'fk_cd_area_area_atuacao')->references('cd_area_atuacao')->on('syst.dc_area_atuacao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_subarea_atuacao', 'fk_cd_subarea_area_atuacao')->references('cd_subarea_atuacao')->on('syst.dc_subarea_atuacao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_area_atuacao', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_area_area_atuacao');
			$table->dropForeign('fk_cd_subarea_area_atuacao');
			$table->dropForeign('fk_id_osc');
		});
	}

}
