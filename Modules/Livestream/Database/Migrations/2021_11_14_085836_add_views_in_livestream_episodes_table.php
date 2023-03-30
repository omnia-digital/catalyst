<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->integer('views')->default(0)->index();
            $table->timestamp('views_updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->dropColumn('views');
            $table->dropColumn('views_updated_at');
        });
    }
};
