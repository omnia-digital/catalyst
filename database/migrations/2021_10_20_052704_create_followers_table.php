<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('following_id');
            $table->boolean('local_profile')->default(true)->index();
            $table->boolean('local_following')->default(true)->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();

            $table->unique(['profile_id', 'following_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
}
