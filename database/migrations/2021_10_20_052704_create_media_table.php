<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->boolean('is_nsfw')->default(false);
            $table->boolean('remote_media')->default(false);
            $table->string('original_sha256')->nullable()->index();
            $table->string('optimized_sha256')->nullable()->index();
            $table->string('media_path');
            $table->string('thumbnail_path')->nullable();
            $table->text('cdn_url')->nullable();
            $table->string('optimized_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('remote_url')->nullable();
            $table->text('caption')->nullable();
            $table->string('hls_path')->nullable();
            $table->unsignedTinyInteger('order')->default('1');
            $table->string('mime')->nullable()->index();
            $table->unsignedInteger('size')->nullable();
            $table->string('orientation')->nullable();
            $table->string('filter_name')->nullable();
            $table->string('filter_class')->nullable();
            $table->string('license')->nullable()->index();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('hls_transcoded_at')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
            $table->string('key')->nullable();
            $table->json('metadata')->nullable();
            $table->tinyInteger('version')->default(1);
            $table->string('blurhash')->nullable();
            $table->json('srcset')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->boolean('skip_optimize')->nullable()->index();
            $table->timestamp('replicated_at')->nullable();

            $table->unique(['status_id', 'media_path']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
