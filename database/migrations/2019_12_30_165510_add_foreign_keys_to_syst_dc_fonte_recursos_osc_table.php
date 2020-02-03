<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSystdcFonteRecursosOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syst.dc_fonte_recursos_osc', function(Blueprint $table)
		{
			$table->foreign('cd_origem_fonte_recursos_osc', 'fk_cd_origem_fonte_recursos_osc')->references('cd_origem_fonte_recursos_osc')->on('syst.dc_origem_fonte_recursos_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syst.dc_fonte_recursos_osc', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_origem_fonte_recursos_osc');
		});
	}

}
