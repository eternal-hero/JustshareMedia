<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('authorize_customer_id');
            $table->string('authorize_customer_address_id');
            $table->string('authorize_customer_payment_profile_id');
            $table->float('amount');
            $table->string('type');
            $table->string('status'); // pending, completed, failed
            $table->json('authorize_request_obj');
            $table->json('authorize_response_obj')->nullable();
            $table->string('message')->nullable();
            $table->string('authorize_transaction_id')->nullable();
            $table->string('authorize_auth_code')->nullable();
            $table->string('authorize_transaction_code')->nullable();
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
        Schema::dropIfExists('transaction_attempts');
    }
}
