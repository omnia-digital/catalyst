<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('stripe_connect_id')->nullable()->after('languages');
            $table->boolean('stripe_connect_onboarding_completed')->default(0);
        });
    }

    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('stripe_connect_id');
        });
    }
};
