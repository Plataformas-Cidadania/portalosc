<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbAreaAtuacaoOutraProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_area_atuacao_outra_projeto', function(Blueprint $table)
		{
			$table->foreign('id_projeto', 'fk_id_projeto')->references('id_projeto')->on('osc.tb_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_area_atuacao_outra', 'fk_id_area_atuacao_outra')->references('id_area_atuacao_outra')->on('osc.tb_area_atuacao_outra')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_area_atuacao_outra_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_projeto');
			$table->dropForeign('fk_id_area_atuacao_outra');
		});
	}

}
