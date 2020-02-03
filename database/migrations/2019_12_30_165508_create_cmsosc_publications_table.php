<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCmsoscpublicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cmsosc.publications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('imagem')->nullable();
			$table->string('titulo')->nullable();
			$table->text('resumida')->nullable();
			$table->text('descricao')->nullable();
			$table->text('arquivo')->nullable();
			$table->date('data')->nullable();
			$table->integer('status')->default(0);
			$table->integer('cmsuser_id');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cmsosc.publications');
	}

}
