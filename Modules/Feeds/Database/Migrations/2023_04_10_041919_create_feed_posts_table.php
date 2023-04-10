<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_posts', function (Blueprint $table) {
            $table->id();
            $table->string('feed_id', 32)->index();
            $table->foreignIdFor(\Modules\Social\Models\Post::class)->index();
            $table->timestamps();

            $table->unique(['feed_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_posts');
    }
}
