<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscoverCategoryHashtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discover_category_hashtags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('discover_category_id')->index();
            $table->unsignedBigInteger('hashtag_id')->index();
            $table->timestamps();

            $table->unique(['discover_category_id', 'hashtag_id'], 'disc_hashtag_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discover_category_hashtags');
    }
}
