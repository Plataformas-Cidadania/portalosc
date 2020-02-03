<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsosctiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.tipos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem');
			$table->string('titulo');
			$table->text('arquivo');
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
		Schema::drop('cmsosc.tipos');
	}

}
