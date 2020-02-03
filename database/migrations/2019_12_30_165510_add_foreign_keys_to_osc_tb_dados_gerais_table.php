<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbDadosGeraisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_dados_gerais', function(Blueprint $table)
		{
			$table->foreign('cd_natureza_juridica_osc', 'fk_cd_natureza_juridica_osc')->references('cd_natureza_juridica')->on('syst.dc_natureza_juridica')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_situacao_imovel_osc', 'fk_cd_situacao_imovel_osc')->references('cd_situacao_imovel')->on('syst.dc_situacao_imovel')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_dados_gerais', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_natureza_juridica_osc');
			$table->dropForeign('fk_cd_situacao_imovel_osc');
			$table->dropForeign('fk_id_osc');
		});
	}

}
