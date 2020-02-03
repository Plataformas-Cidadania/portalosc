<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOsctbContatoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('osc.tb_contato', function(Blueprint $table)
		{
			$table->integer('id_osc')->primary('pk_tb_contato')->comment('Identificador da OSC');
			$table->text('tx_telefone')->nullable()->comment('Telefone da OSC');
			$table->text('ft_telefone')->nullable()->comment('Fonte do telefone');
			$table->text('tx_email')->nullable()->comment('Email da OSC');
			$table->text('ft_email')->nullable()->comment('Fonte do email');
			$table->text('nm_representante')->nullable()->comment('Nome do representante legal da OSC');
			$table->text('ft_representante')->nullable()->comment('Fonte do representante');
			$table->text('tx_site')->nullable()->comment('Endereço do site da OSC');
			$table->text('ft_site')->nullable()->comment('Fonte do site');
			$table->text('tx_facebook')->nullable()->comment('Facebook OSC');
			$table->text('ft_facebook')->nullable()->comment('Fonte do facebook');
			$table->text('tx_google')->nullable()->comment('Google+ OSC');
			$table->text('ft_google')->nullable()->comment('Fonte do google');
			$table->text('tx_linkedin')->nullable()->comment('Linkedin OSC');
			$table->text('ft_linkedin')->nullable()->comment('Fonte do linkedin');
			$table->text('tx_twitter')->nullable()->comment('Twitter OSC');
			$table->text('ft_twitter')->nullable()->comment('Fonte twitter');
			$table->boolean('bo_nao_possui_email')->nullable()->default(0);
			$table->boolean('bo_nao_possui_site')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('osc.tb_contato');
	}

}
