<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpatedUfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spat.ed_uf', function(Blueprint $table)
		{
			$table->decimal('eduf_cd_uf', 2, 0)->primary('pk_eduf')->comment('Código da unidade da federação no IBGE');
			$table->string('eduf_nm_uf', 20)->comment('Nome da unidade da federação');
			$table->string('eduf_sg_uf', 2)->comment('Sigla da UF');
			$table->smallInteger('edre_cd_regiao')->comment('Chave estrangeira');
			$table->geometry('eduf_geometry')->comment('Geometria da unidade da federação');
			$table->geometry('eduf_centroid')->comment('Centroide da UF');
			$table->geometry('eduf_bounding_box')->comment('Retângulo envolvente da unidade da federação');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('spat.ed_uf');
	}

}
