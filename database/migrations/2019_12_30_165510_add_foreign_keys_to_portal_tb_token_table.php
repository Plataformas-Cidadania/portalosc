<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPortaltbTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('portal.tb_token', function(Blueprint $table)
		{
			$table->foreign('id_usuario', 'fk_cd_token')->references('id_usuario')->on('portal.tb_usuario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('portal.tb_token', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_token');
		});
	}

}
