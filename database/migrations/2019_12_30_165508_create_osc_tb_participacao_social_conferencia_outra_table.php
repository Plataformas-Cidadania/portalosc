<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbParticipacaoSocialConferenciaOutraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_participacao_social_conferencia_outra', function(Blueprint $table)
		{
			$table->integer('id_conferencia_outra', true)->comment('Identificador da conferência');
			$table->text('tx_nome_conferencia')->comment('Nome da conferência');
			$table->text('ft_nome_conferencia')->nullable()->comment('Fonte do nome da conferência');
			$table->integer('id_conferencia')->comment('Identificador de conferencia');
			$table->unique(['id_conferencia_outra','id_conferencia'], 'ix_tb_participacao_social_conferencia_outra');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_participacao_social_conferencia_outra');
	}

}
