<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSysttbCamposEditaveisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syst.tb_campos_editaveis', function(Blueprint $table)
		{
			$table->integer('id_campo', true);
			$table->text('nome_campo')->nullable();
			$table->boolean('editavel')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syst.tb_campos_editaveis');
	}

}
