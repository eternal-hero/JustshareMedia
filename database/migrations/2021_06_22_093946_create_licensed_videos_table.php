<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licensed_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('video_id')->constrained('gallery_items')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('operate_locations')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['user_id', 'video_id', 'location_id']);
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
        Schema::dropIfExists('licensed_videos');
    }
}
