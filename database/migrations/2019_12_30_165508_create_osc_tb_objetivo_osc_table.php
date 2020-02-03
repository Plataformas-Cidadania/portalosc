<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbObjetivoOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_objetivo_osc', function(Blueprint $table)
		{
			$table->integer('id_objetivo_osc', true)->comment('Identificador do objetivo do OSC');
			$table->integer('id_osc')->comment('Identificador do OSC');
			$table->integer('cd_meta_osc')->comment('Código da meta do OSC');
			$table->text('ft_objetivo_osc')->nullable()->comment('Fonte do objetivo do OSC');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->unique(['id_objetivo_osc','id_osc'], 'ix_tb_objetivo_osc');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_objetivo_osc');
	}

}
