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
            $table->string('name')->nullable();
            $table->text('bio')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            $table->softDeletes()->index();
            $table->timestamp('delete_after')->nullable();
            $table->boolean('is_suggestable')->default(false)->index();
            $table->timestamp('fetched_at')->nullable();
            $table->unsignedInteger('followers_count')->nullable()->default('0');
            $table->unsignedInteger('following_count')->nullable()->default('0');
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
