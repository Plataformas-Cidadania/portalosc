<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcCertificadoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_certificado', function(Blueprint $table)
		{
			$table->integer('cd_certificado', true)->comment('Código do Certificado');
			$table->text('tx_nome_certificado')->comment('Nome do Certificado');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_certificado');
	}

}
