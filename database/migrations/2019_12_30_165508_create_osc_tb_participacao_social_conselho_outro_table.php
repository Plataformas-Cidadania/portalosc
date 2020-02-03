<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbParticipacaoSocialConselhoOutroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_participacao_social_conselho_outro', function(Blueprint $table)
		{
			$table->integer('id_conselho_outro', true)->comment('Identificador outro conselho');
			$table->text('tx_nome_conselho')->comment('Nome do conselho');
			$table->text('ft_nome_conselho')->nullable()->comment('Fonte nome do conselho');
			$table->integer('id_conselho')->comment('Identificador do Conselho');
			$table->unique(['id_conselho_outro','id_conselho'], 'ix_tb_participacao_social_conselho_outro');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_participacao_social_conselho_outro');
	}

}
