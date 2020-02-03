<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIpeadatatbIpeadataUfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ipeadata.tb_ipeadata_uf', function(Blueprint $table)
		{
			$table->integer('id_ipeadata_uf', true)->comment('Identificador do valor por estado');
			$table->decimal('cd_uf', 7, 0)->comment('CÃ³digo do estado');
			$table->integer('nr_ano')->nullable()->comment('Ano em que o valor foi composto');
			$table->integer('cd_indice')->nullable()->comment('CÃ³digo do indice');
			$table->float('nr_valor', 10, 0)->nullable()->comment('Valor do indice');
			$table->index(['cd_uf','cd_indice'], 'ix_ipeadata_uf');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ipeadata.tb_ipeadata_uf');
	}

}
