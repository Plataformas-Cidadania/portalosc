<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbGovernancaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_governanca', function(Blueprint $table)
		{
			$table->integer('id_dirigente', true)->comment('Identificador do Dirigente');
			$table->integer('id_osc')->nullable()->comment('Identificador da OSC');
			$table->text('tx_cargo_dirigente')->comment('Cargo do Dirigente');
			$table->text('ft_cargo_dirigente')->nullable()->comment('Fonte do cargo do dirigente');
			$table->text('tx_nome_dirigente')->comment('Nome do Dirigente');
			$table->text('ft_nome_dirigente')->nullable()->comment('Fonte do nome do dirigente');
			$table->boolean('bo_oficial')->comment('Registro vindo de base oficial');
			$table->unique(['id_dirigente','id_osc'], 'ix_tb_governanca');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_governanca');
	}

}
