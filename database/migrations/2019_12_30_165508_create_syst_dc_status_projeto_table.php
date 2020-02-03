<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcStatusProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_status_projeto', function(Blueprint $table)
		{
			$table->integer('cd_status_projeto', true)->comment('Código do status do projeto');
			$table->text('tx_nome_status_projeto')->comment('Nome do status do projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_status_projeto');
	}

}
