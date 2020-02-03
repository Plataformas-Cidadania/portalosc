<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPortaltbRepresentacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('portal.tb_representacao', function(Blueprint $table)
		{
			$table->foreign('id_osc', 'fk_id_osc')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_usuario', 'fk_id_usuario')->references('id_usuario')->on('portal.tb_usuario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('portal.tb_representacao', function(Blueprint $table)
		{
			$table->dropForeign('fk_id_osc');
			$table->dropForeign('fk_id_usuario');
		});
	}

}
