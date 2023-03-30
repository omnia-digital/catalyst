<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateMuxAssetIdToSourceVideoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Episode::withTrashed()->get()->each(function (App\Models\Episode $episode) {
            $episode->video()->update([
                'video_source_id' => $episode->mux_asset_id,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('livestream_videos', function (Blueprint $table) {
            $table->dropColumn('video_source_id');
        });
    }
}
