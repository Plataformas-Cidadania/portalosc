<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsosclinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.links', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem')->nullable();
			$table->string('titulo')->nullable();
			$table->text('descricao')->nullable();
			$table->string('url')->nullable();
			$table->text('arquivo')->nullable();
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
		Schema::drop('cmsosc.links');
	}

}
