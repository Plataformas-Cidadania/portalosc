<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbParticipacaoSocialOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_participacao_social_outra', function(Blueprint $table)
		{
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
		Schema::table('osc.tb_participacao_social_outra', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_osc');
		});
	}

}
