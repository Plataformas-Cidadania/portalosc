<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbParticipacaoSocialOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_participacao_social_outra', function(Blueprint $table)
		{
			$table->integer('id_participacao_social_outra', true)->comment('Identificador de outra participação social');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->text('tx_nome_participacao_social_outra')->nullable()->comment('Nome da participação social outra');
			$table->text('ft_participacao_social_outra')->nullable()->comment('Fonte da participação social outra');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->boolean('bo_nao_possui')->nullable();
			$table->unique(['id_participacao_social_outra','id_osc'], 'ix_tb_participacao_social_outra');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_participacao_social_outra');
	}

}
