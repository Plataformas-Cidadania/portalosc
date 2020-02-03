<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSystdcMetaProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syst.dc_meta_projeto', function(Blueprint $table)
		{
			$table->foreign('cd_objetivo_projeto', 'fk_cd_objetivo_projeto')->references('cd_objetivo_projeto')->on('syst.dc_objetivo_projeto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syst.dc_meta_projeto', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_objetivo_projeto');
		});
	}

}
