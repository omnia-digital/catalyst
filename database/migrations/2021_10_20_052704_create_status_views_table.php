<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id')->nullable()->index();
            $table->unsignedBigInteger('status_profile_id')->nullable()->index();
            $table->unsignedBigInteger('profile_id')->nullable()->index();
            $table->timestamps();

            $table->unique(['status_id', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_views');
    }
}
