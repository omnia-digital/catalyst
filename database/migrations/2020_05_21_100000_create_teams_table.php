<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('handle')->nullable()->index();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->string('location')->nullable();
            $table->integer('rating')->nullable();
            $table->string('languages')->default('English');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
