<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopologylayerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topology.layer', function(Blueprint $table)
		{
			$table->integer('topology_id');
			$table->integer('layer_id');
			$table->string('schema_name');
			$table->string('table_name');
			$table->string('feature_column');
			$table->integer('feature_type');
			$table->integer('level')->default(0);
			$table->integer('child_id')->nullable();
			$table->unique(['schema_name','table_name','feature_column'], 'layer_schema_name_table_name_feature_column_key');
			$table->primary(['topology_id','layer_id'], 'layer_pkey');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('topology.layer');
	}

}
