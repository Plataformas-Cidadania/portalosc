<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcSituacaoImovelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_situacao_imovel', function(Blueprint $table)
		{
			$table->integer('cd_situacao_imovel', true)->comment('Código da situação');
			$table->text('tx_nome_situacao_imovel')->comment('Nome da situação do imóvel');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_situacao_imovel');
	}

}
