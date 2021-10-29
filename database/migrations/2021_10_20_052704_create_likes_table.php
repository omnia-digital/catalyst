<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id')->index();
            $table->unsignedBigInteger('status_id')->index();
            $table->unsignedBigInteger('status_profile_id')->nullable()->index();
            $table->boolean('is_comment')->nullable()->index();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes()->index();

            $table->unique(['profile_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
