<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('transactions'))
		{
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->default(0);
			$table->date('transaction_date');
			$table->date('today_date');
			$table->string('voucher')->default('paid');
			$table->string('order_id')->default(0);
			$table->string('description')->null();
			$table->float('dr')->default(0);
			$table->float('cr')->default(0);
			$table->string('party_name')->null();
			$table->string('sales_ledger')->null();
			$table->string('form_name')->null();
			$table->string('p_type')->null();
			$table->integer('rel_id')->default(0);
			$table->integer('invoice_number')->null();
			$table->text('comment')->null();
			$table->string('status')->default(1);
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
        Schema::dropIfExists('transactions');
    }
}
