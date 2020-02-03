<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIpeadatatbIpeadataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ipeadata.tb_ipeadata', function(Blueprint $table)
		{
			$table->foreign('cd_indice', 'fk_cd_indice')->references('cd_indice')->on('ipeadata.tb_indice')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_municipio', 'fk_cd_municipio')->references('edmu_cd_municipio')->on('spat.ed_municipio')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ipeadata.tb_ipeadata', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_indice');
			$table->dropForeign('fk_cd_municipio');
		});
	}

}
