<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('episode_series', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Episode::class)->index();
            $table->foreignIdFor(\App\Models\Series::class)->index();
        });

        Schema::create('episode_template_series', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\EpisodeTemplate::class)->index();
            $table->foreignIdFor(\App\Models\Series::class)->index();
        });

        Schema::table('series', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\LivestreamAccount::class)->after('name')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('episode_series');
        Schema::dropIfExists('episode_template_series');

        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('livestream_account_id');
        });
    }
}
