<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class,'user_id');
            $table->string('provider_user_id');
            $table->string('provider');
            $table->text('avatar')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->text('token')->nullable();
            $table->text('team_token')->nullable();
            $table->text('expires_in')->nullable();
            $table->text('refresh_token')->nullable();
            $table->boolean('verified')->nullable();
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
        Schema::dropIfExists('social_accounts');
    }
};
