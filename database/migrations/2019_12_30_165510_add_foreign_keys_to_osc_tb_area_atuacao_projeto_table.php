<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbAreaAtuacaoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_area_atuacao_projeto', function(Blueprint $table)
		{
			$table->foreign('id_projeto', 'fk_id_projeto')->references('id_projeto')->on('osc.tb_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_subarea_atuacao', 'fk_cd_subarea_atuacao')->references('cd_subarea_atuacao')->on('syst.dc_subarea_atuacao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_area_atuacao_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_projeto');
			$table->dropForeign('fk_cd_subarea_atuacao');
		});
	}

}
