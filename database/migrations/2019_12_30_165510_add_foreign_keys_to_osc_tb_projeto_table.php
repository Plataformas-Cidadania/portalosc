<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_projeto', function(Blueprint $table)
		{
			$table->foreign('cd_zona_atuacao_projeto', 'fk_zona_atuacao_projeto')->references('cd_zona_atuacao_projeto')->on('syst.dc_zona_atuacao_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_abrangencia_projeto', 'fk_cd_abrangencia_projeto')->references('cd_abrangencia_projeto')->on('syst.dc_abrangencia_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_municipio', 'fk_cd_municipio')->references('edmu_cd_municipio')->on('spat.ed_municipio')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_status_projeto', 'fk_cd_status_projeto')->references('cd_status_projeto')->on('syst.dc_status_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_uf', 'fk_cd_uf')->references('eduf_cd_uf')->on('spat.ed_uf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_zona_atuacao_projeto');
			$table->dropForeign('fk_cd_abrangencia_projeto');
			$table->dropForeign('fk_cd_municipio');
			$table->dropForeign('fk_cd_status_projeto');
			$table->dropForeign('fk_cd_uf');
			$table->dropForeign('fk_id_osc');
		});
	}

}
