<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorizeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table){
            $table->renameColumn('transaction_id', 'authorize_transaction_id');
            $table->string('authorize_auth_code')->nullable();
            $table->string('authorize_transaction_code')->nullable();
            $table->string('authorize_transaction_description')->nullable();
        });

        Schema::table('users', function (Blueprint $table){
            $table->string('authorize_customer_id')->nullable();
            $table->string('authorize_customer_address_id')->nullable();
            $table->string('authorize_customer_payment_profile_id')->nullable();
        });

        Schema::table('subscriptions', function (Blueprint $table){
            $table->string('authorize_subscription_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
