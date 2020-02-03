<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGraphtbSenaesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('graph.tb_senaes', function(Blueprint $table)
		{
			$table->integer('id_senaes', true);
			$table->text('nom_1')->nullable();
			$table->text('end_2')->nullable();
			$table->text('bai_3')->nullable();
			$table->text('cep_3')->nullable();
			$table->text('cod_munic')->nullable();
			$table->text('mun_4')->nullable();
			$table->text('uf')->nullable();
			$table->text('micro_reg')->nullable();
			$table->text('ema_6')->nullable();
			$table->text('con_7')->nullable();
			$table->text('cnpj_8')->nullable();
			$table->text('tem_cnpj')->nullable();
			$table->text('nat_9')->nullable();
			$table->text('nat_9_or')->nullable();
			$table->text('vin_10')->nullable();
			$table->text('red_11')->nullable();
			$table->text('red_11_or')->nullable();
			$table->text('atu_12_a')->nullable();
			$table->text('atu_12_b')->nullable();
			$table->text('atu_12_c')->nullable();
			$table->text('atu_12_d')->nullable();
			$table->text('atu_12_e')->nullable();
			$table->text('atu_12_f')->nullable();
			$table->text('atu_12_o')->nullable();
			$table->text('atu_12_or')->nullable();
			$table->text('abr_13')->nullable();
			$table->text('abr_13_2_1')->nullable();
			$table->text('abr_13_2_2')->nullable();
			$table->text('abr_13_2_3')->nullable();
			$table->text('abr_13_2_4')->nullable();
			$table->text('abr_13_2_5')->nullable();
			$table->text('abr_13_2_6')->nullable();
			$table->text('abr_13_2_7')->nullable();
			$table->text('num_uf')->nullable();
			$table->text('abr_13_3_1')->nullable();
			$table->text('abr_13_3_2')->nullable();
			$table->text('abr_13_3_3')->nullable();
			$table->text('abr_13_3_4')->nullable();
			$table->text('abr_13_3_5')->nullable();
			$table->text('abr_13_3_6')->nullable();
			$table->text('abr_13_3_7')->nullable();
			$table->text('abr_13_3_8')->nullable();
			$table->text('abr_13_3_9')->nullable();
			$table->text('abr_13_3_10')->nullable();
			$table->text('abr_13_3_11')->nullable();
			$table->text('abr_13_3_12')->nullable();
			$table->text('abr_13_3_13')->nullable();
			$table->text('abr_13_3_14')->nullable();
			$table->text('abr_13_3_15')->nullable();
			$table->text('abr_13_3_16')->nullable();
			$table->text('abr_13_3_17')->nullable();
			$table->text('abr_13_3_18')->nullable();
			$table->text('abr_13_3_19')->nullable();
			$table->text('abr_13_3_20')->nullable();
			$table->text('abr_13_3_21')->nullable();
			$table->text('abr_13_3_22')->nullable();
			$table->text('abr_13_3_23')->nullable();
			$table->text('abr_13_3_24')->nullable();
			$table->text('abr_13_3_25')->nullable();
			$table->text('abr_13_3_26')->nullable();
			$table->text('abr_13_3_27')->nullable();
			$table->text('abr_13_3_28')->nullable();
			$table->text('abr_13_3_29')->nullable();
			$table->text('abr_13_3_30')->nullable();
			$table->text('abr_13_3_31')->nullable();
			$table->text('abr_13_3_32')->nullable();
			$table->text('abr_13_3_33')->nullable();
			$table->text('abr_13_3_34')->nullable();
			$table->text('abr_13_3_35')->nullable();
			$table->text('num_mun')->nullable();
			$table->text('resp')->nullable();
			$table->text('data_cad')->nullable();
			$table->text('website')->nullable();
			$table->text('auto_declarado')->nullable();
			$table->text('auto_declarado_atualizacao')->nullable();
			$table->text('ano_declaracao')->nullable();
			$table->text('num_fone_1')->nullable();
			$table->text('num_fone_2')->nullable();
			$table->text('num_fone_3')->nullable();
			$table->text('num_fone_4')->nullable();
			$table->text('num_fone_5')->nullable();
			$table->text('num_fone_6')->nullable();
			$table->text('ddd_1')->nullable();
			$table->text('ddd_2')->nullable();
			$table->text('ddd_3')->nullable();
			$table->text('ddd_4')->nullable();
			$table->text('ddd_5')->nullable();
			$table->text('ddd_6')->nullable();
			$table->text('tipo_fone_1')->nullable();
			$table->text('tipo_fone_2')->nullable();
			$table->text('tipo_fone_3')->nullable();
			$table->text('tipo_fone_4')->nullable();
			$table->text('tipo_fone_5')->nullable();
			$table->text('tipo_fone_6')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('graph.tb_senaes');
	}

}
