<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbAnaliseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_analise', function(Blueprint $table)
		{
			$table->integer('id_analise')->primary('pk_tb_analise');
			$table->text('configuracao')->nullable();
			$table->integer('tipo_grafico')->nullable();
			$table->text('titulo')->nullable();
			$table->text('legenda')->nullable();
			$table->text('titulo_colunas')->nullable();
			$table->text('legenda_x')->nullable();
			$table->text('legenda_y')->nullable();
			$table->text('parametros')->nullable();
			$table->text('series_1')->nullable();
			$table->text('series_2')->nullable();
			$table->text('fontes')->nullable();
			$table->boolean('inverter_label')->nullable();
			$table->text('slug')->nullable();
			$table->boolean('ativo')->nullable();
			$table->integer('status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_analise');
	}

}
