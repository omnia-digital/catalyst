<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->text('body');
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->nullableMorphs('postable');
            $table->timestamp('published_at')->nullable()->default(now());
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
        Schema::dropIfExists('posts');
    }
}
