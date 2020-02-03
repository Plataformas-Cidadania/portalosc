<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcTipoUsuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_tipo_usuario', function(Blueprint $table)
		{
			$table->integer('cd_tipo_usuario')->primary('pk_dc_tipo_usuario')->comment('Código do tipo de usuário');
			$table->text('tx_nome_tipo_usuario')->comment('Nome do tipo de usuário');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_tipo_usuario');
	}

}
