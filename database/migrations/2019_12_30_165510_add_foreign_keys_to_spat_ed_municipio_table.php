<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSpatedMunicipioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('spat.ed_municipio', function(Blueprint $table)
		{
			$table->foreign('eduf_cd_uf', 'fk_eduf_edmu')->references('eduf_cd_uf')->on('spat.ed_uf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('spat.ed_municipio', function(Blueprint $table)
		{
			$table->dropForeign('fk_eduf_edmu');
		});
	}

}
