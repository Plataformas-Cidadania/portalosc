<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogtbLogAlteracaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log.tb_log_alteracao', function(Blueprint $table)
		{
			$table->integer('id_log_alteracao', true);
			$table->text('tx_nome_tabela');
			$table->integer('id_osc');
			$table->text('tx_fonte_dados');
			$table->dateTime('dt_alteracao');
			$table->text('tx_dado_anterior')->nullable();
			$table->text('tx_dado_posterior')->nullable();
			$table->integer('id_carga')->nullable()->index('ix_tb_log_alteracao_2');
			$table->unique(['id_log_alteracao','id_osc','dt_alteracao'], 'ix_tb_log_alteracao');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log.tb_log_alteracao');
	}

}
