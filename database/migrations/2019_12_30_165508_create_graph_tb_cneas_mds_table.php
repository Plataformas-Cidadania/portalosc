<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGraphtbCneasMdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graph.tb_cneas_mds', function(Blueprint $table)
		{
			$table->integer('id_cneas_mds', true);
			$table->text('cnpj')->nullable();
			$table->text('ibge')->nullable();
			$table->text('uf')->nullable();
			$table->text('municipio')->nullable();
			$table->text('nome_fantasia')->nullable();
			$table->text('razao_social')->nullable();
			$table->text('logradouro')->nullable();
			$table->text('numero')->nullable();
			$table->text('complemento')->nullable();
			$table->text('bairro')->nullable();
			$table->text('cep')->nullable();
			$table->text('email')->nullable();
			$table->text('telefone')->nullable();
			$table->text('bloco_servico')->nullable();
			$table->text('atividade')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('graph.tb_cneas_mds');
	}

}
