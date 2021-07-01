<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('homes'))
		{
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->default(0);
			$table->text('banner_text');
			$table->string('banner_image')->default('default.jpg');
			$table->string('how_to_start1_image')->default('default.jpg');
			$table->string('how_to_start2_image')->default('default.jpg');
			$table->string('how_to_start3_image')->default('default.jpg');
			$table->text('how_to_start1');
			$table->text('how_to_start2');
			$table->text('how_to_start3');
			$table->integer('status')->default(1);
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
        });
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homes');
    }
}
