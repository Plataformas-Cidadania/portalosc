<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCachetbExportarTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cache.tb_exportar', function(Blueprint $table)
		{
			$table->integer('id_exportar', true);
			$table->text('tx_chave')->unique('tb_exportar_tx_chave_key');
			$table->text('tx_valor');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cache.tb_exportar');
	}

}
