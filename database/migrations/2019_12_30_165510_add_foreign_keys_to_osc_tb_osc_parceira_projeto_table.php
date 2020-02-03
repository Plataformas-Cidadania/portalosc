<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbOscParceiraProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_osc_parceira_projeto', function(Blueprint $table)
		{
			$table->foreign('id_osc', 'fk_tb_osc')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_projeto', 'fk_tb_projeto')->references('id_projeto')->on('osc.tb_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_osc_parceira_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_osc');
			$table->dropForeign('fk_tb_projeto');
		});
	}

}
