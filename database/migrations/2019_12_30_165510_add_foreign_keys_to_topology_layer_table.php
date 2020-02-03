<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTopologylayerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('topology.layer', function(Blueprint $table)
		{
			$table->foreign('topology_id', 'layer_topology_id_fkey')->references('id')->on('topology.topology')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('topology.layer', function(Blueprint $table)
		{
			$table->dropForeign('layer_topology_id_fkey');
		});
	}

}
