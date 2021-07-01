<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('lotteries'))
		{
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->default(0);
			$table->string('name');
			$table->string('image')->default('default.jpg');
			$table->string('cat1_val')->default(0);
			$table->string('cat1_max_winner')->default(0);
			$table->string('cat2_val')->default(0);
			$table->string('cat2_max_winner')->default(0);
			$table->string('cat3_val')->default(0);
			$table->string('cat3_max_winner')->default(0);
			$table->string('cat4_val')->default(0);
			$table->string('cat4_max_winner')->default(0);
			$table->string('cat5_val')->default(0);
			$table->string('cat5_max_winner')->default(0);
			$table->string('cat6_val')->default(0);
			$table->string('cat6_max_winner')->default(0);
			$table->string('cat7_val')->default(0);
			$table->string('cat7_max_winner')->default(0);
			$table->string('cat8_val')->default(0);
			$table->string('cat8_max_winner')->default(0);
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
        Schema::dropIfExists('lotteries');
    }
}
