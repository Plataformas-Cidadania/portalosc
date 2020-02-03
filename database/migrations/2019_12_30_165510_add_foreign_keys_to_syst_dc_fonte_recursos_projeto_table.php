<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSystdcFonteRecursosProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syst.dc_fonte_recursos_projeto', function(Blueprint $table)
		{
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
		Schema::table('syst.dc_fonte_recursos_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_origem_fonte_recursos_projeto');
		});
	}

}
