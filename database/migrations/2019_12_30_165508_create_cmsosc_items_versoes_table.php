<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscitemsVersoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.items_versoes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem')->nullable();
			$table->text('arquivo')->nullable();
			$table->integer('tipo_id')->nullable();
			$table->integer('integrante_id')->nullable();
			$table->integer('versao_id');
			$table->integer('cmsuser_id');
			$table->timestamps();
			$table->integer('status')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cmsosc.items_versoes');
	}

}
