<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbCertificadoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_certificado', function(Blueprint $table)
		{
			$table->integer('id_certificado', true)->comment('Identificador do certificado');
			$table->integer('id_osc')->nullable()->comment('Identificador da OSC');
			$table->integer('cd_certificado')->nullable()->comment('Código do certificado');
			$table->text('ft_certificado')->nullable()->comment('Fonte do certificado');
			$table->date('dt_inicio_certificado')->nullable()->comment('Data de início do certificado');
			$table->text('ft_inicio_certificado')->nullable()->comment('Fonte da data de início do certificado');
			$table->date('dt_fim_certificado')->nullable()->comment('Data final do certificado');
			$table->text('ft_fim_certificado')->nullable()->comment('Fonte da data de fim do certificado');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->decimal('cd_municipio', 10, 0)->nullable();
			$table->decimal('cd_uf', 10, 0)->nullable();
			$table->text('ft_municipio')->nullable();
			$table->text('ft_uf')->nullable();
			$table->unique(['id_certificado','id_osc','cd_certificado'], 'ix_tb_certificado');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_certificado');
	}

}
