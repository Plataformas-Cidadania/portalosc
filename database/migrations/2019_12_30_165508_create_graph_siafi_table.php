<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGraphsiafiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graph.siafi', function(Blueprint $table)
		{
			$table->integer('id_siafi', true);
			$table->integer('ano')->nullable();
			$table->integer('mes_numero')->nullable();
			$table->text('funcional')->nullable();
			$table->integer('gnd_cod')->nullable();
			$table->integer('mod_aplic_cod')->nullable();
			$table->integer('elemento_despesa_cod')->nullable();
			$table->bigInteger('id_estab');
			$table->decimal('empenhado', 10, 0)->nullable();
			$table->decimal('pago', 10, 0)->nullable();
			$table->decimal('empenhado_def', 10, 0)->nullable();
			$table->decimal('pago_def', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('graph.siafi');
	}

}
