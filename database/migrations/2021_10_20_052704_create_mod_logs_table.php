<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('object_uid')->nullable()->index();
            $table->unsignedBigInteger('object_id')->nullable()->index();
            $table->string('object_type')->nullable()->index();
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->json('metadata')->nullable();
            $table->string('access_level')->nullable()->default('admin');
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
        Schema::dropIfExists('mod_logs');
    }
}
