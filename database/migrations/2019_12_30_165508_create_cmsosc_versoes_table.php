<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscversoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.versoes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem')->nullable();
			$table->text('arquivo')->nullable();
			$table->string('titulo')->nullable();
			$table->text('descricao')->nullable();
			$table->integer('cmsuser_id');
			$table->timestamps();
			$table->integer('status')->default(0);
			$table->integer('posicao')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cmsosc.versoes');
	}

}
