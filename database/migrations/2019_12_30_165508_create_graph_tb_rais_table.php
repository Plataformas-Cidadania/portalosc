<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGraphtbRaisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graph.tb_rais', function(Blueprint $table)
		{
			$table->integer('id_tb_rais', true);
			$table->bigInteger('id_estab');
			$table->integer('codemun')->nullable();
			$table->text('nm_mun')->nullable();
			$table->integer('uf')->nullable();
			$table->text('nm_uf')->nullable();
			$table->integer('regiao')->nullable();
			$table->text('nm_regiao')->nullable();
			$table->text('secao_cnae20')->nullable();
			$table->integer('div_cnae20')->nullable();
			$table->integer('grp_cnae20')->nullable();
			$table->integer('clas_cnae20')->nullable();
			$table->integer('sbcl_cnae20')->nullable();
			$table->integer('nat_jur')->nullable();
			$table->text('razao_social')->nullable();
			$table->integer('tamestab')->nullable();
			$table->integer('tamestab2')->nullable();
			$table->integer('qtd_vinc_ativos')->nullable();
			$table->integer('qtd_portador_defic')->nullable();
			$table->text('data_abertura')->nullable();
			$table->text('data_encerramento')->nullable();
			$table->text('data_baixa')->nullable();
			$table->integer('ind_atividade')->nullable();
			$table->integer('ind_rais_neg')->nullable();
			$table->integer('ind_osc')->nullable();
			$table->integer('ano_abertura')->nullable();
			$table->integer('ano_rais')->nullable();
			$table->text('nat_jur_corrigido')->nullable();
			$table->text('sbcl_cnae_corrigido')->nullable();
			$table->integer('in_cnis16')->nullable();
			$table->integer('ano_true')->nullable();
			$table->text('div_cnae20_corrigido')->nullable();
			$table->text('grp_cnae20_corrigido')->nullable();
			$table->text('clas_cnae20_corrigido')->nullable();
			$table->text('secao_cnae20_corrigido')->nullable();
			$table->text('micro_area_atuacao')->nullable();
			$table->text('macro_area_atuacao')->nullable();
			$table->unique(['id_estab','ano_rais'], 'cnpj');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('graph.tb_rais');
	}

}
