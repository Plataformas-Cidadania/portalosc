<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbRepresentanteConselhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_representante_conselho', function(Blueprint $table)
		{
			$table->integer('id_representante_conselho', true)->comment('Identificador do representante de conselho');
			$table->integer('id_osc')->nullable()->comment('Identificador da OSC');
			$table->integer('id_participacao_social_conselho')->comment('Identificador do conselho');
			$table->text('tx_nome_representante_conselho')->comment('Nome do representante de conselho');
			$table->text('ft_nome_representante_conselho')->nullable()->comment('Fonte do nome do representante de conselho');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->unique(['id_representante_conselho','id_osc'], 'ix_tb_representante_conselho');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_representante_conselho');
	}

}
