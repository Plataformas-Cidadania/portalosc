<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGraphtbOrcamentoDefTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graph.tb_orcamento_def', function(Blueprint $table)
		{
			$table->integer('id_orcamento_def', true)->comment('Identificador do orcamento');
			$table->decimal('nr_orcamento_cnpj', 10, 0)->nullable()->comment('CNPJ da OSC');
			$table->integer('nr_orcamento_ano')->nullable()->comment('Ano em que o orcamento foi repassado');
			$table->float('nr_vl_empenhado_def', 10, 0)->nullable()->comment('Valor do orcamento');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('graph.tb_orcamento_def');
	}

}
