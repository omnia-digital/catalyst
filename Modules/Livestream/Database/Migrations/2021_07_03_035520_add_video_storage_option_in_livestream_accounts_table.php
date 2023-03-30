<?php

use Modules\Livestream\Enums\VideoStorageOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoStorageOptionInLivestreamAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('livestream_accounts', function (Blueprint $table) {
            $table->string('video_storage_option')->default(VideoStorageOption::PAY_VIDEO_STORAGE)->after('team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('livestream_accounts', function (Blueprint $table) {
            $table->dropColumn('video_storage_option');
        });
    }
}
