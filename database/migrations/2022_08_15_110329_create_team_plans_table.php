<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        /** @note We are not using this currently. Save for future when we want teams to create custom plans */
        Schema::create('team_plans', function (Blueprint $table) {
            //$table->id();
            //$table->foreignIdFor(\App\Models\Team::class)->index();
            //$table->string('stripe_id')->unique();
            //$table->string('name');
            //$table->string('description')->nullable();
            //$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_plans');
    }
};
