<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id')->index();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_type')->nullable();
            $table->string('action')->nullable();
            $table->string('message')->nullable();
            $table->string('rendered')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
