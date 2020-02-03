<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpatedMunicipioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spat.ed_municipio', function(Blueprint $table)
		{
			$table->decimal('edmu_cd_municipio', 7, 0)->primary('pk_edmu')->comment('Código do municipio no IBGE');
			$table->string('edmu_nm_municipio', 50)->comment('Nome do municipio');
			$table->smallInteger('eduf_cd_uf')->comment('Chave estrangeira');
			$table->geometry('edmu_geometry')->comment('Geometria do municipio');
			$table->geometry('edmu_centroid')->comment('Centróide do município');
			$table->geometry('edmu_bounding_box')->comment('Retângulo envolvente do município');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('spat.ed_municipio');
	}

}
