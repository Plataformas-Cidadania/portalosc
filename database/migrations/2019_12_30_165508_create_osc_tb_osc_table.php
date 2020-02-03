<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbOscTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_osc', function(Blueprint $table)
		{
			$table->integer('id_osc', true)->comment('Identificador da OSC');
			$table->text('tx_apelido_osc')->nullable()->unique('unique_tx_apelido_osc')->comment('Apelido da OSC');
			$table->text('ft_apelido_osc')->nullable()->comment('Fonte do apelido da OSC');
			$table->decimal('cd_identificador_osc', 14, 0)->unique('un_cd_identificador_osc')->comment('Número de identificação da OSC - CNPJ ou CEI');
			$table->text('ft_identificador_osc')->nullable()->comment('Fonte do número identificador da OSC');
			$table->text('ft_osc_ativa')->nullable()->comment('Fonte do status da OSC');
			$table->boolean('bo_osc_ativa')->comment('Flag de OSC Ativa');
			$table->boolean('bo_nao_possui_projeto')->nullable();
			$table->text('ft_nao_possui_projeto')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_osc');
	}

}
