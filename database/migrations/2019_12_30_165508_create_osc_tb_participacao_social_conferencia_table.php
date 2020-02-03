<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbParticipacaoSocialConferenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_participacao_social_conferencia', function(Blueprint $table)
		{
			$table->integer('id_conferencia', true)->comment('Identificador da conferência');
			$table->integer('cd_conferencia')->comment('Código da conferência');
			$table->text('ft_conferencia')->nullable()->comment('Fonte da conferência');
			$table->integer('id_osc')->comment('Identificador da OSC');
			$table->date('dt_ano_realizacao')->nullable()->comment('Ano de realização da conferência');
			$table->text('ft_ano_realizacao')->nullable()->comment('Fonte do ano de realização da conferência');
			$table->integer('cd_forma_participacao_conferencia')->nullable()->comment('Código da forma de participação em conferência');
			$table->text('ft_forma_participacao_conferencia')->nullable()->comment('Fonte da forma participação conferência');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->unique(['id_conferencia','id_osc','cd_conferencia'], 'ix_tb_participacao_social_conferencia');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_participacao_social_conferencia');
	}

}
