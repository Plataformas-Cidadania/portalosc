<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortaltbUsuarioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tb_usuario', function(Blueprint $table)
		{
			$table->integer('id_usuario', true);
			$table->integer('cd_tipo_usuario')->comment('Código do tipo de usuário');
			$table->text('tx_email_usuario')->unique('un_email_usuario');
			$table->text('tx_senha_usuario');
			$table->text('tx_nome_usuario');
			$table->decimal('nr_cpf_usuario', 11, 0)->nullable()->unique('un_cpf_usuario');
			$table->boolean('bo_lista_email');
			$table->boolean('bo_ativo');
			$table->dateTime('dt_cadastro');
			$table->dateTime('dt_atualizacao')->nullable();
			$table->integer('cd_municipio')->nullable();
			$table->integer('cd_uf')->nullable();
			$table->boolean('bo_email_confirmado')->default(1);
			$table->text('tx_telefone_1')->nullable();
			$table->text('tx_telefone_2')->nullable();
			$table->text('tx_orgao_trabalha')->nullable();
			$table->text('tx_dado_institucional')->nullable();
			$table->text('tx_email_confirmacao')->nullable();
			$table->boolean('bo_lista_atualizacao_anual')->nullable()->default(0);
			$table->boolean('bo_lista_atualizacao_trimestral')->nullable()->default(0);
			$table->unique(['id_usuario','cd_tipo_usuario'], 'ix_tb_usuario');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portal.tb_usuario');
	}

}
