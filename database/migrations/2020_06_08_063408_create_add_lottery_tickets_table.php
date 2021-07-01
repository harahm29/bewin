<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddLotteryTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('add_lottery_tickets'))
		{
        Schema::create('add_lottery_tickets', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->default(0);
			$table->integer('lottery_id')->default(0);
			$table->string('lottery_name');
			$table->string('lottery_price');
			$table->string('lottery_no');
			$table->string('power_ball_no');
			$table->string('lottery_type');
			$table->date('today_date');
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
        Schema::dropIfExists('add_lottery_tickets');
    }
}
