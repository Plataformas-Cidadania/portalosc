<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbFonteRecursosProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_fonte_recursos_projeto', function(Blueprint $table)
		{
			$table->integer('id_fonte_recursos_projeto', true)->comment('Identificador da fonte de recursos do projeto');
			$table->integer('id_projeto')->comment('Identificador do projeto');
			$table->integer('cd_fonte_recursos_projeto')->nullable()->comment('Código da fonte de recursos do projeto');
			$table->text('ft_fonte_recursos_projeto')->nullable()->comment('Fonte dos dados da fonte de recursos do projeto');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->integer('cd_origem_fonte_recursos_projeto')->nullable();
			$table->text('tx_orgao_concedente')->nullable();
			$table->text('ft_orgao_concedente')->nullable();
			$table->text('tx_tipo_parceria_outro')->nullable();
			$table->unique(['id_fonte_recursos_projeto','id_projeto'], 'ix_tb_fonte_recursos_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_fonte_recursos_projeto');
	}

}
