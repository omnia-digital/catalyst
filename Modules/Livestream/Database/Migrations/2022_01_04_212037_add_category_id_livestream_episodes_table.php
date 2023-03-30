<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdLivestreamEpisodesTable extends Migration
{
    public function up()
    {
        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Category::class)->index()->nullable();
        });
    }

    public function down()
    {
        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
