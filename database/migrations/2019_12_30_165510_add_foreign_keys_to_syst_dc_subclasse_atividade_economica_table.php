<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSystdcSubclasseAtividadeEconomicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syst.dc_subclasse_atividade_economica', function(Blueprint $table)
		{
			$table->foreign('cd_classe_atividade_economica', 'fk_dc_subclasse_atividade_economica')->references('cd_classe_atividade_economica')->on('syst.dc_classe_atividade_economica')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syst.dc_subclasse_atividade_economica', function(Blueprint $table)
		{
			$table->dropForeign('fk_dc_subclasse_atividade_economica');
		});
	}

}
