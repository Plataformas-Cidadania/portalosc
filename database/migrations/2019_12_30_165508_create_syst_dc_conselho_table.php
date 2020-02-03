<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcConselhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_conselho', function(Blueprint $table)
		{
			$table->integer('cd_conselho', true)->comment('Código do conselho');
			$table->text('tx_nome_conselho')->comment('Nome do conselho ou comissão');
			$table->string('tx_nome_orgao_vinculado', 100)->nullable()->comment('Orgão ao qual a comissão ou conselho está vinculado');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_conselho');
	}

}
