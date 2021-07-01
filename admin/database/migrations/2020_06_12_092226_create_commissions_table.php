<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('commissions'))
		{
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->default(0);
			$table->string('name');
			$table->integer('min_val')->default(0);
			$table->integer('max_val')->default(0);
			$table->integer('percentage')->default(0);
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
        Schema::dropIfExists('commissions');
    }
}
