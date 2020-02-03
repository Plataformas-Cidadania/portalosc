<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbBarraTransparenciaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_barra_transparencia', function(Blueprint $table)
		{
			$table->integer('id_barra_transparencia', true);
			$table->integer('id_osc')->unique('tb_barra_transparencia_id_osc_key');
			$table->decimal('transparencia_dados_gerais', 10, 0)->nullable();
			$table->float('peso_dados_gerais', 10, 0)->nullable();
			$table->decimal('transparencia_area_atuacao', 10, 0)->nullable();
			$table->float('peso_area_atuacao', 10, 0)->nullable();
			$table->decimal('transparencia_descricao', 10, 0)->nullable();
			$table->float('peso_descricao', 10, 0)->nullable();
			$table->decimal('transparencia_titulos_certificacoes', 10, 0)->nullable();
			$table->float('peso_titulos_certificacoes', 10, 0)->nullable();
			$table->decimal('transparencia_relacoes_trabalho_governanca', 10, 0)->nullable();
			$table->float('peso_relacoes_trabalho_governanca', 10, 0)->nullable();
			$table->decimal('transparencia_espacos_participacao_social', 10, 0)->nullable();
			$table->float('peso_espacos_participacao_social', 10, 0)->nullable();
			$table->decimal('transparencia_projetos_atividades_programas', 10, 0)->nullable();
			$table->float('peso_projetos_atividades_programas', 10, 0)->nullable();
			$table->decimal('transparencia_fontes_recursos', 10, 0)->nullable();
			$table->float('peso_fontes_recursos', 10, 0)->nullable();
			$table->decimal('transparencia_osc', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_barra_transparencia');
	}

}
