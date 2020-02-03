<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPortaltbAnaliseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('portal.tb_analise', function(Blueprint $table)
		{
			$table->foreign('tipo_grafico', 'fk_tipo_grafico')->references('id_grafico')->on('syst.tb_tipo_grafico')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('portal.tb_analise', function(Blueprint $table)
		{
			$table->dropForeign('fk_tipo_grafico');
		});
	}

}
