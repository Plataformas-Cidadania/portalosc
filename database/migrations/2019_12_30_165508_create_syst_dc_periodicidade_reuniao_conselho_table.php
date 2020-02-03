<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcPeriodicidadeReuniaoConselhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_periodicidade_reuniao_conselho', function(Blueprint $table)
		{
			$table->integer('cd_periodicidade_reuniao_conselho', true)->comment('Código da periodicidade de reunião de conselho');
			$table->text('tx_nome_periodicidade_reuniao_conselho')->comment('Nome da periodicidade de reunião de conselho');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_periodicidade_reuniao_conselho');
	}

}
