<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbEditalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_edital', function(Blueprint $table)
		{
			$table->integer('id_edital', true)->comment('Identificador do Edital');
			$table->text('tx_orgao')->comment('Orgão do Edital');
			$table->text('tx_programa')->nullable()->comment('Programa do edital');
			$table->text('tx_area_interesse_edital')->nullable()->comment('Área de Interesse do edital');
			$table->date('dt_vencimento')->nullable()->comment('Data de vencimento');
			$table->text('tx_link_edital')->comment('Link do edital');
			$table->text('tx_numero_chamada')->nullable()->comment('Número da chamada');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_edital');
	}

}
