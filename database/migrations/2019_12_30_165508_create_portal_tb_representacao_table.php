<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbRepresentacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_representacao', function(Blueprint $table)
		{
			$table->integer('id_representacao', true);
			$table->integer('id_osc')->nullable()->comment('Chave estrangeira (código da OSC)');
			$table->integer('id_usuario')->nullable()->comment('Chave estrangeira (código do Usuário)');
			$table->unique(['id_representacao','id_osc','id_usuario'], 'ix_tb_representacao');
			$table->unique(['id_osc','id_usuario'], 'un_representante');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_representacao');
	}

}
