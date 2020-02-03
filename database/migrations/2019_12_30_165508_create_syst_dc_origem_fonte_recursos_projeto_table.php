<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcOrigemFonteRecursosProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_origem_fonte_recursos_projeto', function(Blueprint $table)
		{
			$table->integer('cd_origem_fonte_recursos_projeto', true)->comment('Código da origem de fonte de recursos de projeto');
			$table->text('tx_nome_origem_fonte_recursos_projeto')->comment('Nome da origem de fonte de recursos de projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_origem_fonte_recursos_projeto');
	}

}
