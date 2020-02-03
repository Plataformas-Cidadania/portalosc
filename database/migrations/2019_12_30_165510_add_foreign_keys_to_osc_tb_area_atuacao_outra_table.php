<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbAreaAtuacaoOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_area_atuacao_outra', function(Blueprint $table)
		{
			$table->foreign('id_area_atuacao_declarada', 'fk_id_area_atuacao_declarada')->references('id_area_atuacao_declarada')->on('osc.tb_area_atuacao_declarada')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('osc.tb_area_atuacao_outra', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_area_atuacao_declarada');
			$table->dropForeign('fk_id_osc');
		});
	}

}
