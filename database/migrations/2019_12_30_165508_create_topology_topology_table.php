<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopologytopologyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topology.topology', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->unique('topology_name_key');
			$table->integer('srid');
			$table->float('precision', 10, 0);
			$table->boolean('hasz')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('topology.topology');
	}

}
