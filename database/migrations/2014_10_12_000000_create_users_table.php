<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('users'))
		{
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile_no');
			$table->string('other_email')->nullable();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users');
			$table->date('dob')->nullable();
			$table->string('document_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
			$table->text('address')->nullable();
			$table->string('user_image')->default('default.jpg');
			$table->string('type')->default('user');
			$table->string('user_token')->nullable();
			$table->string('firebase_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
