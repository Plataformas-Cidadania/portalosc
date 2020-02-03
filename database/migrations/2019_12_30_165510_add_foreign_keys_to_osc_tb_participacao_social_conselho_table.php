<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbParticipacaoSocialConselhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_participacao_social_conselho', function(Blueprint $table)
		{
			$table->foreign('cd_conselho', 'fk_cd_conselho')->references('cd_conselho')->on('syst.dc_conselho')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_periodicidade_reuniao_conselho', 'fk_cd_periodicidade_reuniao_conselho')->references('cd_periodicidade_reuniao_conselho')->on('syst.dc_periodicidade_reuniao_conselho')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_tipo_participacao', 'fk_cd_tipo_participacao')->references('cd_tipo_participacao')->on('syst.dc_tipo_participacao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_participacao_social_conselho', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_conselho');
			$table->dropForeign('fk_cd_periodicidade_reuniao_conselho');
			$table->dropForeign('fk_cd_tipo_participacao');
			$table->dropForeign('fk_id_osc');
		});
	}

}
