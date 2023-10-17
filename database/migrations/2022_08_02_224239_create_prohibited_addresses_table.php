<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProhibitedAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prohibited_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_item_id');
            $table->foreign('gallery_item_id')->references('id')->on('gallery_items');
            $table->string('lat');
            $table->string('lng');
            $table->string('name');
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
        Schema::dropIfExists('prohibited_addresses');
    }
}
