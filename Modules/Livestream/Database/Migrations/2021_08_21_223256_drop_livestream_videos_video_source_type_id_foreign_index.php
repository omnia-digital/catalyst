<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLivestreamVideosVideoSourceTypeIdForeignIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('livestream_videos', 'video_source_type_id')) {
            Schema::table('livestream_videos', function (Blueprint $table) {
                // @NOTE - disabling this for now since it was only used when migrating from the old omnia db and the new migration I created doesn't add it.
//                $table->dropForeign('livestream_videos_video_source_type_id_foreign');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
