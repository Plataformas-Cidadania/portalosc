<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbRecursosOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_recursos_osc', function(Blueprint $table)
		{
			$table->integer('id_recursos_osc', true)->comment('Identificador de recursos da OSC');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->integer('cd_fonte_recursos_osc')->nullable()->comment('Código da fonte de recursos da OSC');
			$table->text('ft_fonte_recursos_osc')->nullable()->comment('Fonte da fonte de recursos da OSC');
			$table->date('dt_ano_recursos_osc')->comment('Ano dos recursos da OSC');
			$table->text('ft_ano_recursos_osc')->nullable()->comment('Fonte do ano dos recursos da OSC');
			$table->float('nr_valor_recursos_osc', 10, 0)->nullable()->comment('Valor do recursos da OSC');
			$table->text('ft_valor_recursos_osc')->nullable()->comment('Fonte do valor do recursos da OSC');
			$table->boolean('bo_nao_possui')->nullable();
			$table->text('ft_nao_possui')->nullable();
			$table->integer('cd_origem_fonte_recursos_osc')->nullable();
			$table->unique(['id_osc','cd_origem_fonte_recursos_osc','cd_fonte_recursos_osc','dt_ano_recursos_osc'], 'un_recursos_osc');
			$table->unique(['id_osc','id_recursos_osc'], 'ix_tb_recursos_osc');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_recursos_osc');
	}

}
