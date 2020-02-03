<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSystdcSubareaAtuacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syst.dc_subarea_atuacao', function(Blueprint $table)
		{
			$table->foreign('cd_area_atuacao', 'fk_cd_id_area_atuacao')->references('cd_area_atuacao')->on('syst.dc_area_atuacao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syst.dc_subarea_atuacao', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_id_area_atuacao');
		});
	}

}
