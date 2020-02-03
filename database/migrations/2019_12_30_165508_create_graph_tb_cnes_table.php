<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGraphtbCnesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graph.tb_cnes', function(Blueprint $table)
		{
			$table->integer('id_cnes', true);
			$table->text('nu_cnpj_requerente')->nullable();
			$table->text('no_pessoa')->nullable();
			$table->text('no_regiao')->nullable();
			$table->text('sg_uf')->nullable();
			$table->text('no_municipio')->nullable();
			$table->text('a_lei')->nullable();
			$table->text('tempestividade')->nullable();
			$table->text('nu_sipar')->nullable();
			$table->text('dt_protocolo')->nullable();
			$table->text('dt_protocolo_menor')->nullable();
			$table->text('assunto')->nullable();
			$table->text('cebas_atual')->nullable();
			$table->text('inicio_validade_anterior')->nullable();
			$table->text('fim_validade_anterior')->nullable();
			$table->text('cnes')->nullable();
			$table->text('co_cnes')->nullable();
			$table->text('nu_cnpj')->nullable();
			$table->text('nu_cnpj_mantenedora')->nullable();
			$table->text('no_razao_social')->nullable();
			$table->text('no_fantasia')->nullable();
			$table->text('regiao')->nullable();
			$table->text('uf')->nullable();
			$table->text('co_municipio')->nullable();
			$table->text('municipio')->nullable();
			$table->text('no_logradouro')->nullable();
			$table->text('nu_endereco')->nullable();
			$table->text('no_complemento')->nullable();
			$table->text('no_bairro')->nullable();
			$table->text('co_cep')->nullable();
			$table->text('co_natureza_jur')->nullable();
			$table->text('ds_natureza_juridica')->nullable();
			$table->text('ds_retencao_tributo')->nullable();
			$table->text('ds_motivo_desab')->nullable();
			$table->text('co_natureza_organizacao')->nullable();
			$table->text('ds_natureza_organizacao')->nullable();
			$table->text('co_esfera_administrativa')->nullable();
			$table->text('ds_esfera_administrativa')->nullable();
			$table->text('ds_tipo_unidade')->nullable();
			$table->text('ds_gestao')->nullable();
			$table->text('st_registro_ativo')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('graph.tb_cnes');
	}

}
