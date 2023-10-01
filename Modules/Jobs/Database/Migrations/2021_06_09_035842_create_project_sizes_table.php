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
        Schema::create('project_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::table('job_positions', function (Blueprint $table) {
            $table->foreignId('project_size_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_sizes');

        Schema::table('job_positions', function (Blueprint $table) {
            $table->dropColumn('project_size_id');
        });
    }
};
