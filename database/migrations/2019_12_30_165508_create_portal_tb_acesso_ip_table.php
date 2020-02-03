<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbAcessoIpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_acesso_ip', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('tx_ip')->unique('un_tx_ip');
			$table->dateTime('dt_data_expiracao');
			$table->integer('nr_quantidade_acessos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_acesso_ip');
	}

}
