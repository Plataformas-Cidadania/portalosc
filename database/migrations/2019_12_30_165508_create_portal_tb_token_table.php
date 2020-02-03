<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_token', function(Blueprint $table)
		{
			$table->integer('id_token', true)->comment('Identificador do token');
			$table->integer('id_usuario')->comment('Chave estrangeira');
			$table->text('tx_token')->comment('Token do usuário');
			$table->date('dt_data_expiracao_token')->nullable()->comment('Data de expiração do token');
			$table->unique(['id_token','id_usuario'], 'ix_tb_token');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_token');
	}

}
