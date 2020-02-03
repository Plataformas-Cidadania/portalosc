<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpatedRegiaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spat.ed_regiao', function(Blueprint $table)
		{
			$table->decimal('edre_cd_regiao', 10, 0)->primary('pk_edre')->comment('Código da macroregião no IBGE');
			$table->string('edre_sg_regiao', 2)->comment('Sigla da região');
			$table->string('edre_nm_regiao', 20)->comment('Nome da Macroregiao');
			$table->geometry('edre_geometry')->comment('Geometria da Macroregião');
			$table->geometry('edre_centroid')->comment('Centroide da região');
			$table->geometry('edre_bounding_box')->comment('Retângulo envolvente da macroregião');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('spat.ed_regiao');
	}

}
