<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOsctbCertificadoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('osc.tb_certificado', function(Blueprint $table)
		{
			$table->foreign('cd_municipio', 'fk_cd_municipio')->references('edmu_cd_municipio')->on('spat.ed_municipio')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_uf', 'fk_cd_uf')->references('eduf_cd_uf')->on('spat.ed_uf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('cd_certificado', 'fk_cod_certificado')->references('cd_certificado')->on('syst.dc_certificado')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_osc', 'fk_id_osc')->references('id_osc')->on('osc.tb_osc')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('osc.tb_certificado', function(Blueprint $table)
		{
			$table->dropForeign('fk_cd_municipio');
			$table->dropForeign('fk_cd_uf');
			$table->dropForeign('fk_cod_certificado');
			$table->dropForeign('fk_id_osc');
		});
	}

}
