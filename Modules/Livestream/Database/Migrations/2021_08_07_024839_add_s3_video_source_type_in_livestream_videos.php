<?php

use Illuminate\Database\Migrations\Migration;

class AddS3VideoSourceTypeInLivestreamVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Video::query()
            ->where(fn ($query) => $query->whereNull('video_source_type_id')->orWhere('video_source_type_id', ''))
            ->get()
            ->each(function (App\Models\Video $video) {
                $video->update(['video_source_type_id' => 6]);
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
