<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogtbLogErroCargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log.tb_log_erro_carga', function(Blueprint $table)
		{
			$table->integer('id_log_erro_carga', true)->comment('Código sequência do log');
			$table->decimal('cd_identificador_osc', 10, 0)->comment('Número do CNPJ da OSC');
			$table->smallInteger('cd_status')->comment('Chave estrangeira');
			$table->text('tx_mensagem')->comment('Mensagem de log');
			$table->dateTime('dt_carregamento_dados')->nullable()->comment('Data de carregamento dos dados');
			$table->integer('id_carga')->nullable();
			$table->unique(['id_log_erro_carga','cd_identificador_osc'], 'ix_tb_log_erro_carga');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log.tb_log_erro_carga');
	}

}
