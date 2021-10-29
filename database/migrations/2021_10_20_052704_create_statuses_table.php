<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('uri')->nullable()->unique();
            $table->text('caption')->nullable();
            $table->text('rendered')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable()->index();
            $table->string('type')->nullable()->index();
            $table->unsignedBigInteger('in_reply_to_id')->nullable();
            $table->unsignedBigInteger('reblog_of_id')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_nsfw')->default(false)->index();
            $table->string('scope')->default('public')->index();
            $table->enum('visibility', ['public', 'unlisted', 'private', 'direct', 'draft'])->default('public')->index();
            $table->boolean('reply')->default(false);
            $table->unsignedBigInteger('likes_count')->default('0');
            $table->unsignedBigInteger('reblogs_count')->default('0');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->boolean('local')->default(true)->index();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('in_reply_to_profile_id')->nullable();
            $table->json('entities')->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes()->index();
            $table->string('cw_summary')->nullable();
            $table->unsignedInteger('reply_count')->nullable();
            $table->boolean('comments_disabled')->default(false);
            $table->unsignedBigInteger('place_id')->nullable()->index();
            $table->string('object_url')->nullable()->unique();

            $table->index(['in_reply_to_id', 'reblog_of_id'], 'statuses_in_reply_or_reblog_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
