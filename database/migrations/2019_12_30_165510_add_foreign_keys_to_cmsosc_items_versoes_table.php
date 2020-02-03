<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsoscitemsVersoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cmsosc.items_versoes', function(Blueprint $table)
		{
			$table->foreign('cmsuser_id', 'items_versoes_cmsuser_id_foreign')->references('id')->on('cmsosc.cms_users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('versao_id', 'items_versoes_versao_id_foreign')->references('id')->on('cmsosc.versoes')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cmsosc.items_versoes', function(Blueprint $table)
		{
			$table->dropForeign('items_versoes_cmsuser_id_foreign');
			$table->dropForeign('items_versoes_versao_id_foreign');
		});
	}

}
