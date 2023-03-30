<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('video_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('viewer_id')->index();
            $table->string('os')->nullable();
            $table->string('browser')->nullable();
            $table->string('country_code')->nullable();
            $table->string('video_title');
            $table->timestamp('view_start');
            $table->timestamp('view_end');
            $table->foreignIdFor(\App\Models\Video::class)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_views');
    }
};
