<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('livestream_videos', function (Blueprint $table) {
            $table->text('playback_url')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('livestream_videos', function (Blueprint $table) {
            $table->string('playback_url')->nullable()->change();
        });
    }
};
