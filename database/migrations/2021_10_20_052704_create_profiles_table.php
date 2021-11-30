<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('handle')->nullable()->index();
            $table->string('status')->nullable()->index();
            $table->string('name')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('unlisted')->default(false)->index();
            $table->boolean('cw')->default(false)->index();
            $table->boolean('no_autolink')->default(false)->index();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('profile_layout')->nullable();
            $table->string('header_bg')->nullable();
            $table->string('post_layout')->nullable();
            $table->boolean('is_private')->default(false);
            $table->string('sharedInbox')->nullable()->index();
            $table->string('inbox_url')->nullable();
            $table->string('outbox_url')->nullable();
            $table->string('follower_url')->nullable();
            $table->string('following_url')->nullable();
            $table->text('private_key')->nullable();
            $table->text('public_key')->nullable();
            $table->string('remote_url')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
            $table->timestamp('delete_after')->nullable();
            $table->boolean('is_suggestable')->default(false)->index();
            $table->timestamp('last_fetched_at')->nullable();
            $table->unsignedInteger('status_count')->nullable()->default('0');
            $table->unsignedInteger('followers_count')->nullable()->default('0');
            $table->unsignedInteger('following_count')->nullable()->default('0');
            $table->string('webfinger')->nullable()->unique();
            $table->string('avatar_url')->nullable();

            $table->unique(['handle']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
