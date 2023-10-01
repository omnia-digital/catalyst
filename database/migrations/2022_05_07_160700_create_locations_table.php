<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('locations')) {
            return;
        }
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('address');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_locations');
    }
}
