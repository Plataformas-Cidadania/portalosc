<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbFonteRecursosProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_fonte_recursos_projeto', function(Blueprint $table)
		{
			$table->foreign('id_projeto', 'fk_id_projeto')->references('id_projeto')->on('osc.tb_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_fonte_recursos_projeto', 'fk_cd_fonte_recursos_projeto')->references('cd_fonte_recursos_projeto')->on('syst.dc_fonte_recursos_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_origem_fonte_recursos_projeto', 'fk_cd_origem_fonte_recursos_projeto')->references('cd_origem_fonte_recursos_projeto')->on('syst.dc_origem_fonte_recursos_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_fonte_recursos_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_projeto');
			$table->dropForeign('fk_cd_fonte_recursos_projeto');
			$table->dropForeign('fk_cd_origem_fonte_recursos_projeto');
		});
	}

}
