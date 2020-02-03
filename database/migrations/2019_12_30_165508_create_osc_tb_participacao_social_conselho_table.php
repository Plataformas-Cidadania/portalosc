<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbParticipacaoSocialConselhoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_participacao_social_conselho', function(Blueprint $table)
		{
			$table->integer('id_conselho', true)->comment('Identificador da tabela conselho');
			$table->integer('id_osc')->nullable()->comment('Identificador da OSC');
			$table->integer('cd_conselho')->nullable()->comment('Chave estrangeira (código do conselho)');
			$table->text('ft_conselho')->nullable()->comment('Fonte do conselho');
			$table->integer('cd_tipo_participacao')->nullable()->comment('Código do tipo de participação');
			$table->text('ft_tipo_participacao')->nullable()->comment('Fonte do tipo de participação');
			$table->text('ft_periodicidade_reuniao')->nullable()->comment('Fonte da periodicidade da reunião');
			$table->date('dt_data_inicio_conselho')->nullable()->comment('Data de início da participação no conselho');
			$table->text('ft_data_inicio_conselho')->nullable()->comment('Fonte da data de início da participação no conselho');
			$table->date('dt_data_fim_conselho')->nullable()->comment('Data de fim da participação no conselho');
			$table->text('ft_data_fim_conselho')->nullable()->comment('Fonte da data de início da participação no conselho');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->integer('cd_periodicidade_reuniao_conselho')->nullable();
			$table->unique(['id_conselho','id_osc','cd_conselho'], 'ix_tb_participacao_social_conselho');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_participacao_social_conselho');
	}

}
