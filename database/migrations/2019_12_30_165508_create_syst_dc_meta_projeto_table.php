<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcMetaProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_meta_projeto', function(Blueprint $table)
		{
			$table->integer('cd_meta_projeto', true)->comment('Código da meta do projeto');
			$table->integer('cd_objetivo_projeto')->comment('Còdigo do obketivo do projeto');
			$table->text('tx_nome_meta_projeto')->comment('Nome da meta de projeto');
			$table->text('tx_codigo_meta_projeto')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_meta_projeto');
	}

}
