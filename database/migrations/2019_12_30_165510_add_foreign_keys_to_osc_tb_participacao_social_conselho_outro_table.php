<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbParticipacaoSocialConselhoOutroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_participacao_social_conselho_outro', function(Blueprint $table)
		{
			$table->foreign('id_conselho', 'fk_id_conselho')->references('id_conselho')->on('osc.tb_participacao_social_conselho')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_participacao_social_conselho_outro', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_conselho');
		});
	}

}
