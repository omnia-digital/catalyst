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
        Schema::create('job_position_job_position_addon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_position_id')->index();
            $table->unsignedBigInteger('job_position_addon_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_job_addon');
    }
};
