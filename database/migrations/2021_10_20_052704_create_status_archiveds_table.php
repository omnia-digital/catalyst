<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusArchivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_archiveds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id')->index();
            $table->unsignedBigInteger('profile_id')->index();
            $table->string('original_scope')->nullable();
            $table->json('metadata')->nullable();
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
        Schema::dropIfExists('status_archiveds');
    }
}
