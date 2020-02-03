<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystdcFormaParticipacaoConferenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.dc_forma_participacao_conferencia', function(Blueprint $table)
		{
			$table->integer('cd_forma_participacao_conferencia', true);
			$table->text('tx_nome_forma_participacao_conferencia')->comment('Nome da forma de participação em conferência');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.dc_forma_participacao_conferencia');
	}

}
