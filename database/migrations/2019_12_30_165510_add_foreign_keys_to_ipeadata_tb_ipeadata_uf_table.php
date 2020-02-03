<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIpeadatatbIpeadataUfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ipeadata.tb_ipeadata_uf', function(Blueprint $table)
		{
			$table->foreign('cd_indice', 'fk_cd_indice_uf')->references('cd_indice')->on('ipeadata.tb_indice')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_uf', 'fk_cd_uf')->references('eduf_cd_uf')->on('spat.ed_uf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ipeadata.tb_ipeadata_uf', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_indice_uf');
			$table->dropForeign('fk_cd_uf');
		});
	}

}
