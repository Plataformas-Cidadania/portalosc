<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbRelacoesTrabalhoOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_relacoes_trabalho_outra', function(Blueprint $table)
		{
			$table->foreign('id_osc', 'id_osc')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_relacoes_trabalho_outra', function(Blueprint $table)
		{
			$table->dropForeign('id_osc');
		});
	}

}
