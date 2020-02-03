<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPortaltbUsuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('portal.tb_usuario', function(Blueprint $table)
		{
			$table->foreign('cd_municipio', 'fk_cd_municipio')->references('edmu_cd_municipio')->on('spat.ed_municipio')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_tipo_usuario', 'fk_cd_tipo_usuario')->references('cd_tipo_usuario')->on('syst.dc_tipo_usuario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('portal.tb_usuario', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_municipio');
			$table->dropForeign('fk_cd_tipo_usuario');
			$table->dropForeign('fk_cd_uf');
		});
	}

}
