<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIpeadatatbIpeadataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ipeadata.tb_ipeadata', function(Blueprint $table)
		{
			$table->integer('id_ipeadata', true)->comment('Identificador do valor por municipio');
			$table->decimal('cd_municipio', 7, 0)->comment('CÃ³digo do municipio');
			$table->integer('nr_ano')->nullable()->comment('Ano em que o valor foi composto');
			$table->integer('cd_indice')->nullable()->comment('CÃ³digo do indice');
			$table->float('nr_valor', 10, 0)->nullable()->comment('Valor do indice');
			$table->index(['cd_municipio','cd_indice'], 'ix_ipeadata');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ipeadata.tb_ipeadata');
	}

}
