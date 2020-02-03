<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsoscitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cmsosc.items', function(Blueprint $table)
		{
			$table->foreign('cmsuser_id', 'items_cmsuser_id_foreign')->references('id')->on('cmsosc.cms_users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('modulo_id', 'items_modulo_id_foreign')->references('id')->on('cmsosc.modulos')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cmsosc.items', function(Blueprint $table)
		{
			$table->dropForeign('items_cmsuser_id_foreign');
			$table->dropForeign('items_modulo_id_foreign');
		});
	}

}
