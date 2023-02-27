<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassageColumnsInLivestreamEpisodesTable extends Migration
{
    public function up()
    {
        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->string('main_passage')->nullable()->after('scripture');
            $table->string('other_passages')->nullable()->after('main_passage');
        });
    }

    public function down()
    {
        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->dropColumn('main_passage');
            $table->dropColumn('other_passages');
        });
    }
}
