<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamCategoriesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('team_categories')) {
            return;
        }
        Schema::create('team_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        if (Schema::hasTable('team_team_category')) {
            return;
        }
        Schema::create('team_team_category', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Team::class)->index();
            $table->foreignIdFor(\App\Models\TeamCategory::class)->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_categories');
    }
}
