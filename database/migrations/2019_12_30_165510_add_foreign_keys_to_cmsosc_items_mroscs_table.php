<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCmsoscitemsMroscsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cmsosc.items_mroscs', function(Blueprint $table)
		{
			$table->foreign('cmsuser_id', 'items_mroscs_cmsuser_id_foreign')->references('id')->on('cmsosc.cms_users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('mrosc_id', 'items_mroscs_mrosc_id_foreign')->references('id')->on('cmsosc.mroscs')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cmsosc.items_mroscs', function(Blueprint $table)
		{
			$table->dropForeign('items_mroscs_cmsuser_id_foreign');
			$table->dropForeign('items_mroscs_mrosc_id_foreign');
		});
	}

}
