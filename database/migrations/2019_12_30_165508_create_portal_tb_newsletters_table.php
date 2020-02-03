<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbNewslettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_newsletters', function(Blueprint $table)
		{
			$table->integer('id_newsletters', true)->comment('Identificador da tabela newslatters');
			$table->text('tx_nome_assinante')->comment('Nome do assinante');
			$table->text('tx_email_assinante')->unique('un_email_assinante')->comment('Email do assinante');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_newsletters');
	}

}
