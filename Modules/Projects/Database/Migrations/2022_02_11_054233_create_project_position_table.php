<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_position', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Modules\Projects\Models\Project::class, 'project_id');
            $table->foreignIdFor(\App\Modules\Projects\Models\Position::class, 'position_id');
            $table->foreignIdFor(\App\Models\User::class, 'owner_id');
            $table->timestamp('position_filled');
            $table->bigInteger('points');
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
        Schema::dropIfExists('project_position');
    }
}
