<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('team_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class, 'team_id');
            $table->foreignIdFor(User::class, 'user_id');
            $table->string('role')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_applications');
    }
};
