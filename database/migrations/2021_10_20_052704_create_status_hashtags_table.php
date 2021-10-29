<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusHashtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_hashtags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id')->index();
            $table->unsignedBigInteger('hashtag_id')->index();
            $table->unsignedBigInteger('profile_id')->nullable()->index();
            $table->string('status_visibility')->nullable()->index();
            $table->timestamps();

            $table->unique(['status_id', 'hashtag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_hashtags');
    }
}
