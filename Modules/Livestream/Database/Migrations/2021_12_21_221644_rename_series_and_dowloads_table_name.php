<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('episode_template_series', 'livestream_episode_template_series');
        Schema::rename('episode_series', 'livestream_episode_series');
        Schema::rename('episode_downloads', 'livestream_episode_downloads');
    }

    public function down()
    {

    }
};
