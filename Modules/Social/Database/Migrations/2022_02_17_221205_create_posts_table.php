<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignIdFor(User::class, 'user_id')->index();
            $table->unsignedBigInteger('team_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->text('body');
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->nullableMorphs('postable');
            $table->unsignedBigInteger('repost_original_id')->index()->nullable();
            $table->timestamp('published_at')->nullable();
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
};
