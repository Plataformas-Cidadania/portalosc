<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbRecursosOutroOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_recursos_outro_osc', function(Blueprint $table)
		{
			$table->integer('id_recursos_outro_osc', true)->comment('Identificador de outro recursos da OSC');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->text('tx_nome_fonte_recursos_outro_osc')->comment('Nome da fonte de outro recursos da OSC');
			$table->text('ft_nome_fonte_recursos_outro_osc')->nullable()->comment('Fonte da fonte de outro recursos da OSC');
			$table->date('dt_ano_recursos_outro_osc')->comment('Ano do outro recursos da OSC');
			$table->text('ft_ano_recursos_outro_osc')->nullable()->comment('Fonte do outro recursos da OSC');
			$table->float('nr_valor_recursos_outro_osc', 10, 0)->comment('Valor de outro recursos da OSC');
			$table->text('ft_valor_recursos_outro_osc')->nullable()->comment('Fonte do valor de outro recursos da OSC');
			$table->unique(['id_osc','id_recursos_outro_osc'], 'ix_tb_recursos_outro_osc');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_recursos_outro_osc');
	}

}
