<?php

use Illuminate\Database\Migrations\Migration;

class MigratePlaybackableTypeInPlaybackIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\PlaybackId::query()
            ->where('playbackable_type', 'App\Episode')
            ->get()
            ->each(function (App\Models\PlaybackId $playbackId) {
                $episode = \App\Models\Episode::withTrashed()->find($playbackId->playbackable_id);

                if ($episode) {
                    $video = $episode->video ?: \App\Models\Video::create([
                        'title' => $episode->title,
                        'video_source_id' => $episode->mux_asset_id,
                        'video_source_type_id' => $episode->mux_asset_id ? 3 : 6, // Mux or S3
                    ]);

                    $playbackId->forceFill([
                        'playbackable_type' => \App\Models\Video::class,
                        'playbackable_id' => $video->id,
                    ])->save();
                }
            });

        \App\Models\PlaybackId::query()
            ->where('playbackable_type', 'App\Stream')
            ->get()
            ->each(function (App\Models\PlaybackId $playbackId) {
                $playbackId->forceFill(['playbackable_type' => \App\Models\Stream::class])->save();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
