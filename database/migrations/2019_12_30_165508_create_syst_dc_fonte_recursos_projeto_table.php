<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcFonteRecursosProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_fonte_recursos_projeto', function(Blueprint $table)
		{
			$table->integer('cd_fonte_recursos_projeto', true)->comment('Código da fonte de recursos de projeto');
			$table->integer('cd_origem_fonte_recursos_projeto')->comment('Código da origem da fonte de recursos de projeto');
			$table->text('tx_nome_fonte_recursos_projeto')->comment('Nome da fonte de recursos de projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_fonte_recursos_projeto');
	}

}
