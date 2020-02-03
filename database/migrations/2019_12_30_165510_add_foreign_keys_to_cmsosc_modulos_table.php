<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsoscmodulosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cmsosc.modulos', function(Blueprint $table)
		{
			$table->foreign('cmsuser_id', 'modulos_cmsuser_id_foreign')->references('id')->on('cmsosc.cms_users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('tipo_id', 'modulos_tipo_id_foreign')->references('id')->on('cmsosc.tipos')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cmsosc.modulos', function(Blueprint $table)
		{
			$table->dropForeign('modulos_cmsuser_id_foreign');
			$table->dropForeign('modulos_tipo_id_foreign');
		});
	}

}
