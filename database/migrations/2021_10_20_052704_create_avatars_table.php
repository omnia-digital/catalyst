<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvatarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avatars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id')->unique();
            $table->string('media_path')->nullable();
            $table->string('remote_url')->nullable()->index();
            $table->string('cdn_url')->nullable()->unique();
            $table->boolean('is_remote')->nullable()->index();
            $table->unsignedInteger('size')->nullable();
            $table->unsignedInteger('change_count')->default('0');
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamp('last_processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avatars');
    }
}
