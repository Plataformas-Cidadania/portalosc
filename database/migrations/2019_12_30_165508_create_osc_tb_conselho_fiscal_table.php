<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbConselhoFiscalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_conselho_fiscal', function(Blueprint $table)
		{
			$table->integer('id_conselheiro', true)->comment('Identificador do conselheiro');
			$table->integer('id_osc')->nullable()->comment('Identificador da OSC');
			$table->text('tx_nome_conselheiro')->comment('Nome do conselheiro');
			$table->text('ft_nome_conselheiro')->nullable()->comment('Fonte nome do conselheiro');
			$table->boolean('bo_oficial')->comment('Registro vindo de base oficial');
			$table->unique(['id_conselheiro','id_osc'], 'ix_tb_conselho_fiscal');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_conselho_fiscal');
	}

}
