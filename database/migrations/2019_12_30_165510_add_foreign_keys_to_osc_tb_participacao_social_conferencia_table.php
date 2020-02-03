<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbParticipacaoSocialConferenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_participacao_social_conferencia', function(Blueprint $table)
		{
			$table->foreign('cd_conferencia', 'fk_cd_conferencia')->references('cd_conferencia')->on('syst.dc_conferencia')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_forma_participacao_conferencia', 'fk_cd_forma_participacao_conferencia')->references('cd_forma_participacao_conferencia')->on('syst.dc_forma_participacao_conferencia')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_participacao_social_conferencia', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_conferencia');
			$table->dropForeign('fk_cd_forma_participacao_conferencia');
			$table->dropForeign('fk_id_osc');
		});
	}

}
