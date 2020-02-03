<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcNaturezaJuridicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_natureza_juridica', function(Blueprint $table)
		{
			$table->decimal('cd_natureza_juridica', 4, 0)->primary('pk_dc_natureza_juridica')->comment('Código da natureza jurídica');
			$table->text('tx_nome_natureza_juridica')->comment('Denominação da natureza jurídica');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_natureza_juridica');
	}

}
