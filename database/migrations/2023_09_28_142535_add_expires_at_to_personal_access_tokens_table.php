<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('personal_access_tokens')) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->timestamp('expires_at')->nullable()->after('last_used_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (app()->environment('local')) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->dropColumn('expires_at');
        });
        }
    }
};
