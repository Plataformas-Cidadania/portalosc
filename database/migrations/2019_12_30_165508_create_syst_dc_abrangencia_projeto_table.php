<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcAbrangenciaProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_abrangencia_projeto', function(Blueprint $table)
		{
			$table->integer('cd_abrangencia_projeto', true);
			$table->text('tx_nome_abrangencia_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_abrangencia_projeto');
	}

}
