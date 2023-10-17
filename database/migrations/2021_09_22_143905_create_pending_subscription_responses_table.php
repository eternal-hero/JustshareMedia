<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingSubscriptionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_subscription_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pending_subscription_id');
            $table->foreign('pending_subscription_id')->references('id')->on('pending_subscriptions');
            $table->boolean('is_successful');
            $table->text('message')->nullable();
            $table->string('error_code')->nullable();
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
        Schema::dropIfExists('pending_subscription_responses');
    }
}
