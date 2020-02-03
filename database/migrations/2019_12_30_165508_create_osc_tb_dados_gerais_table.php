<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbDadosGeraisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_dados_gerais', function(Blueprint $table)
		{
			$table->integer('id_osc')->primary('pk_tb_dados_gerais')->comment('Identificador OSC');
			$table->decimal('cd_natureza_juridica_osc', 4, 0)->nullable()->comment('Código da natureza jurídica');
			$table->text('ft_natureza_juridica_osc')->nullable()->comment('Fonte da natureza jurídica');
			$table->text('tx_razao_social_osc')->comment('Razão Social OSC');
			$table->text('ft_razao_social_osc')->nullable()->comment('Fonte da razão social');
			$table->text('tx_nome_fantasia_osc')->nullable()->comment('Nome Fantasia OSC');
			$table->text('ft_nome_fantasia_osc')->nullable()->comment('Fonte do nome fantasia');
			$table->text('im_logo')->nullable()->comment('Imagem da OSC');
			$table->text('ft_logo')->nullable()->comment('Fonte do logo');
			$table->text('tx_missao_osc')->nullable()->comment('Missão da OSC');
			$table->text('ft_missao_osc')->nullable()->comment('Fonte da missão');
			$table->text('tx_visao_osc')->nullable()->comment('Visão da OSC');
			$table->text('ft_visao_osc')->nullable()->comment('Fonte da visão');
			$table->date('dt_fundacao_osc')->nullable()->comment('Data de Fundação da OSC');
			$table->text('ft_fundacao_osc')->nullable()->comment('Fonte data de fundação');
			$table->date('dt_ano_cadastro_cnpj')->nullable()->comment('Data de cadastro do CNPJ da OSC');
			$table->text('ft_ano_cadastro_cnpj')->nullable()->comment('Fonte da data de cadastro do CNPJ da OSC');
			$table->text('tx_sigla_osc')->nullable()->comment('Sigla da OSC');
			$table->text('ft_sigla_osc')->nullable()->comment('Fonte sigla');
			$table->text('tx_resumo_osc')->nullable()->comment('Resumo da OSC');
			$table->text('ft_resumo_osc')->nullable()->comment('Fonte resumo');
			$table->integer('cd_situacao_imovel_osc')->nullable()->comment('Situação do Imóvel da OSC');
			$table->text('ft_situacao_imovel_osc')->nullable()->comment('Fonte situação do imóvel');
			$table->text('tx_link_estatuto_osc')->nullable()->comment('Link do estatuto da OSC');
			$table->text('ft_link_estatuto_osc')->nullable()->comment('Fonte link do estatuto');
			$table->text('tx_historico')->nullable()->comment('Descrição do histórico da OSC');
			$table->text('ft_historico')->nullable()->comment('Fonte do histórico da OSC');
			$table->text('tx_finalidades_estatutarias')->nullable()->comment('Descrição das finalidades estatutárias da OSC');
			$table->text('ft_finalidades_estatutarias')->nullable()->comment('Fonte finalidades estatutarias');
			$table->text('tx_link_relatorio_auditoria')->nullable()->comment('Link do relatório de auditoria');
			$table->text('ft_link_relatorio_auditoria')->nullable()->comment('Fonte link relatório de auditoria');
			$table->text('tx_link_demonstracao_contabil')->nullable()->comment('Link da demostração contábil');
			$table->text('ft_link_demonstracao_contabil')->nullable()->comment('Fonte link demonstração contábil');
			$table->text('tx_nome_responsavel_legal')->nullable()->comment('Nome do responável legal');
			$table->text('ft_nome_responsavel_legal')->nullable()->comment('Fonte nome do responsável legal');
			$table->string('cd_classe_atividade_economica_osc')->nullable();
			$table->text('ft_classe_atividade_economica_osc')->nullable();
			$table->boolean('bo_nao_possui_sigla_osc')->nullable()->default(0);
			$table->boolean('bo_nao_possui_link_estatuto_osc')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_dados_gerais');
	}

}
