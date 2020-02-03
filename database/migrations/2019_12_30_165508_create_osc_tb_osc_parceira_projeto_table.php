<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbOscParceiraProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_osc_parceira_projeto', function(Blueprint $table)
		{
			$table->integer('id_osc')->comment('Identificação da OSC');
			$table->integer('id_projeto')->comment('Identificação do Projeto');
			$table->text('ft_osc_parceira_projeto')->nullable()->comment('Fonte da ligação');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->integer('id_osc_parceira_projeto', true);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_osc_parceira_projeto');
	}

}
