<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbConferenciaDeclaradaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_conferencia_declarada', function(Blueprint $table)
		{
			$table->integer('id_conferencia_declarada', true)->comment('Identificador da conferência declarada');
			$table->text('tx_nome_conferencia_declarada')->comment('Nome da conferência declarada');
			$table->text('ft_conferencia_declarada')->nullable()->comment('Fonte da conferência declarada');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_conferencia_declarada');
	}

}
