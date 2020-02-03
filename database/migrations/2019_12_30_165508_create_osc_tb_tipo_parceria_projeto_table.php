<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbTipoParceriaProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_tipo_parceria_projeto', function(Blueprint $table)
		{
			$table->integer('id_tipo_parceria_projeto', true)->comment('Identificador do tipo de parceria do projeto');
			$table->integer('id_projeto')->comment('Identificador do projeto');
			$table->integer('cd_tipo_parceria_projeto')->nullable()->comment('Código da tipo de parceria do projeto');
			$table->text('ft_tipo_parceria_projeto')->nullable()->comment('Fonte do tipo de parceria do projeto');
			$table->integer('id_fonte_recursos_projeto')->nullable();
			$table->unique(['id_tipo_parceria_projeto','id_projeto'], 'ix_tb_tipo_parceria_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_tipo_parceria_projeto');
	}

}
