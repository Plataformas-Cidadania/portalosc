<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbTipoParceriaProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_tipo_parceria_projeto', function(Blueprint $table)
		{
			$table->foreign('id_projeto', 'fk_id_projeto')->references('id_projeto')->on('osc.tb_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_tipo_parceria_projeto', 'fk_cd_tipo_parceria_projeto')->references('cd_tipo_parceria')->on('syst.dc_tipo_parceria')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_fonte_recursos_projeto', 'fk_id_fonte_recursos_projeto')->references('id_fonte_recursos_projeto')->on('osc.tb_fonte_recursos_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_tipo_parceria_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_projeto');
			$table->dropForeign('fk_cd_tipo_parceria_projeto');
			$table->dropForeign('fk_id_fonte_recursos_projeto');
		});
	}

}
