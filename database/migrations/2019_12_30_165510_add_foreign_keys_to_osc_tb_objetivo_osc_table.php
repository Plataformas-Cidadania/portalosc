<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbObjetivoOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_objetivo_osc', function(Blueprint $table)
		{
			$table->foreign('id_osc', 'fk_id_osc')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_meta_osc', 'fk_cd_meta_osc')->references('cd_meta_projeto')->on('syst.dc_meta_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_objetivo_osc', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_osc');
			$table->dropForeign('fk_cd_meta_osc');
		});
	}

}
