<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id')->nullable()->index();
            $table->unsignedBigInteger('media_id')->index();
            $table->unsignedBigInteger('profile_id')->index();
            $table->string('tagged_handle')->nullable();
            $table->boolean('is_public')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['media_id', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_tags');
    }
}
