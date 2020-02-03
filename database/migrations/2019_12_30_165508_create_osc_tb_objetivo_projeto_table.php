<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbObjetivoProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_objetivo_projeto', function(Blueprint $table)
		{
			$table->integer('id_objetivo_projeto', true)->comment('Identificador do objetivo do projeto');
			$table->integer('id_projeto')->comment('Identificador do projeto');
			$table->integer('cd_meta_projeto')->comment('Código da meta do projeto');
			$table->text('ft_objetivo_projeto')->nullable()->comment('Fonte do objetivo do projeto');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->unique(['id_objetivo_projeto','id_projeto'], 'ix_tb_objetivo_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_objetivo_projeto');
	}

}
