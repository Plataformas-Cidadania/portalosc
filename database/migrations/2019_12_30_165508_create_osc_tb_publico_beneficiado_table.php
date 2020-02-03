<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbPublicoBeneficiadoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_publico_beneficiado', function(Blueprint $table)
		{
			$table->integer('id_publico_beneficiado', true);
			$table->text('tx_nome_publico_beneficiado');
			$table->text('ft_publico_beneficiado')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_publico_beneficiado');
	}

}
