<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('codes'))
		{
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->default(0);
			$table->integer('voucher_id')->default(0);
			$table->integer('commission_id')->default(0);
			$table->string('code')->default(0);
			$table->float('value')->default(0);
			$table->date('today_date');
			$table->date('expire_date');
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
        Schema::dropIfExists('codes');
    }
}
