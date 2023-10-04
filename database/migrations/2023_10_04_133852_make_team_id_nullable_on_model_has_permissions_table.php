<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropPrimary('team_id');
            $table->dropColumn('team_id');
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
