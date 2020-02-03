<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbParticipacaoSocialConferenciaOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_participacao_social_conferencia_outra', function(Blueprint $table)
		{
			$table->foreign('id_conferencia', 'fk_id_conferencia')->references('id_conferencia')->on('osc.tb_participacao_social_conferencia')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_participacao_social_conferencia_outra', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_conferencia');
		});
	}

}
