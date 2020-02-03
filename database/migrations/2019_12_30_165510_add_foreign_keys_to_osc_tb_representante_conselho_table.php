<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbRepresentanteConselhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_representante_conselho', function(Blueprint $table)
		{
			$table->foreign('id_participacao_social_conselho', 'fk_id_participacao_social_conselho')->references('id_conselho')->on('osc.tb_participacao_social_conselho')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_representante_conselho', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_participacao_social_conselho');
			$table->dropForeign('fk_id_osc');
		});
	}

}
