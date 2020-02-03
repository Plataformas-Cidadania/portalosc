<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbProjetoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_projeto', function(Blueprint $table)
		{
			$table->integer('id_projeto', true)->comment('Identificador do projeto');
			$table->integer('id_osc')->nullable()->comment('Identificador da OSC');
			$table->text('tx_nome_projeto')->nullable()->comment('Nome do projeto');
			$table->text('ft_nome_projeto')->nullable()->comment('Fonte do nome do projeto');
			$table->integer('cd_status_projeto')->nullable()->comment('Código do status do projeto');
			$table->text('ft_status_projeto')->nullable()->comment('Fonte do status do projeto');
			$table->date('dt_data_inicio_projeto')->nullable()->comment('Data do início do projeto');
			$table->text('ft_data_inicio_projeto')->nullable()->comment('Fonte da data de inicio do projeto');
			$table->date('dt_data_fim_projeto')->nullable()->comment('Data do fim do projeto');
			$table->text('ft_data_fim_projeto')->nullable()->comment('Fonte da data do fim do projeto');
			$table->text('tx_link_projeto')->nullable()->comment('Link do projeto');
			$table->text('ft_link_projeto')->nullable()->comment('Fonte do link do projeto');
			$table->integer('nr_total_beneficiarios')->nullable()->comment('Número total de beneficiarios do projeto');
			$table->text('ft_total_beneficiarios')->nullable()->comment('Fonte total de beneficiários');
			$table->float('nr_valor_captado_projeto', 10, 0)->nullable()->comment('Valor captado do projeto');
			$table->text('ft_valor_captado_projeto')->nullable()->comment('Fonte valor captado do projeto');
			$table->float('nr_valor_total_projeto', 10, 0)->nullable()->comment('Valor total do projeto');
			$table->text('ft_valor_total_projeto')->nullable()->comment('Fonte do valor total do projeto');
			$table->integer('cd_abrangencia_projeto')->nullable()->comment('Código da abrangência do projeto');
			$table->text('ft_abrangencia_projeto')->nullable()->comment('Fonte abrangencia do projeto');
			$table->integer('cd_zona_atuacao_projeto')->nullable()->comment('Código da zona de atuação do projeto');
			$table->text('ft_zona_atuacao_projeto')->nullable()->comment('Fonte da zona de atuação do projeto');
			$table->text('tx_descricao_projeto')->nullable()->comment('Descrição do projeto');
			$table->text('ft_descricao_projeto')->nullable()->comment('Fonte da descrição do projeto');
			$table->text('ft_metodologia_monitoramento')->nullable()->comment('Fonte da metodologia de monitoramento do projeto');
			$table->text('tx_metodologia_monitoramento')->nullable()->comment('Metodologia de monitoramento do projeto');
			$table->text('tx_identificador_projeto_externo')->nullable()->comment('Identificador externo de projeto');
			$table->text('ft_identificador_projeto_externo')->nullable()->comment('Fonte de projeto externo');
			$table->boolean('bo_oficial')->nullable()->comment('Registro vindo de base oficial');
			$table->text('tx_status_projeto_outro')->nullable();
			$table->integer('cd_municipio')->nullable();
			$table->text('ft_municipio')->nullable();
			$table->integer('cd_uf')->nullable();
			$table->text('ft_uf')->nullable();
			$table->unique(['tx_identificador_projeto_externo','cd_uf'], 'unique_projeto_uf');
			$table->unique(['tx_identificador_projeto_externo','cd_municipio'], 'unique_projeto_municipio');
			$table->unique(['id_osc','id_projeto'], 'ix_tb_projeto');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_projeto');
	}

}
