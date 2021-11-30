<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id')->nullable()->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->nullable()->index();
            $table->boolean('2fa_enabled')->default(false);
            $table->string('2fa_secret')->nullable();
            $table->json('2fa_backup_codes')->nullable();
            $table->timestamp('2fa_setup_at')->nullable();
            $table->rememberToken();
            $table->boolean('has_interstitial')->default(false)->index();
            $table->string('language')->nullable()->index();
            $table->foreignId('current_team_id')->nullable();
            $table->timestamp('last_active_at')->nullable()->index();
            $table->timestamp('delete_after')->nullable();
            $table->softDeletes()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
