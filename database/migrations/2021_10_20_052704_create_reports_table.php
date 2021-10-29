<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('object_id');
            $table->string('object_type')->nullable();
            $table->unsignedBigInteger('reported_profile_id')->nullable();
            $table->string('type')->nullable();
            $table->string('message')->nullable();
            $table->timestamp('admin_seen')->nullable();
            $table->boolean('not_interested')->default(false);
            $table->boolean('spam')->default(false);
            $table->boolean('nsfw')->default(false);
            $table->boolean('abusive')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'object_type', 'object_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
