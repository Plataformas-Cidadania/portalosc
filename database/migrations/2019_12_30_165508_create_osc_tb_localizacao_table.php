<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbLocalizacaoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_localizacao', function(Blueprint $table)
		{
			$table->integer('id_osc')->primary('pk_tb_localizacao')->comment('Identificador da OSC');
			$table->text('tx_endereco')->nullable()->comment('Descrição do endereço com Logradouro, número e bairro');
			$table->text('ft_endereco')->nullable()->comment('Fonte do endereço');
			$table->text('nr_localizacao')->nullable()->comment('Número da localização');
			$table->text('ft_localizacao')->nullable()->comment('Fonte do número da localização');
			$table->text('tx_endereco_complemento')->nullable()->comment('Complemento do endereço');
			$table->text('ft_endereco_complemento')->nullable()->comment('Fonte complemento do endereço');
			$table->text('tx_bairro')->nullable()->comment('Nome do Bairro quando houver na fonte de dados');
			$table->text('ft_bairro')->nullable()->comment('Fonte do bairro');
			$table->decimal('cd_municipio', 7, 0)->comment('Chave estrangeira do município');
			$table->text('ft_municipio')->nullable()->comment('Fonte do município');
			$table->geometry('geo_localizacao')->nullable()->comment('Localização da OSC na fonte de dados em coordenadas geográficas (Geometria Postgis)');
			$table->text('ft_geo_localizacao')->nullable()->comment('Fonte de geolocalização');
			$table->decimal('nr_cep', 8, 0)->nullable()->comment('Código de endereçamento postal');
			$table->text('ft_cep')->nullable()->comment('Fonte do CEP');
			$table->text('tx_endereco_corrigido')->nullable()->comment('Endereço formatado e corrigido após processo de geocodificação');
			$table->text('ft_endereco_corrigido')->nullable()->comment('Fonte do endereço corrido');
			$table->text('tx_bairro_encontrado')->nullable()->comment('Bairro encontrado após a geocodificação dos endereços');
			$table->text('ft_bairro_encontrado')->nullable()->comment('Fonte bairro encontrado');
			$table->integer('cd_fonte_geocodificacao')->nullable()->comment('Chave estrangeira (código da fonte da geocodificação)');
			$table->text('ft_fonte_geocodificacao')->nullable()->comment('Fonte do dado de fonte da geocodificação');
			$table->date('dt_geocodificacao')->nullable()->comment('Data da geocodificação');
			$table->text('ft_data_geocodificacao')->nullable()->comment('Fonte da data de geocodificação');
			$table->boolean('bo_oficial')->comment('Registro vindo de base oficial');
			$table->text('qualidade_classificacao')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_localizacao');
	}

}
