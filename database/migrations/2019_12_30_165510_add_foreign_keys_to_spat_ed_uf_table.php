<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSpatedUfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('spat.ed_uf', function(Blueprint $table)
		{
			$table->foreign('edre_cd_regiao', 'fk_edre_eduf')->references('edre_cd_regiao')->on('spat.ed_regiao')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('spat.ed_uf', function(Blueprint $table)
		{
			$table->dropForeign('fk_edre_eduf');
		});
	}

}
