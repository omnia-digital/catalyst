<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('timestamps_to_users', function (Blueprint $table) {
            $table->timestamp('first_login_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('timestamps_to_users', function (Blueprint $table) {
            //
        });
    }
};
