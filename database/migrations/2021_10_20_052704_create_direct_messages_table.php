<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('to_id')->index();
            $table->unsignedBigInteger('from_id')->index();
            $table->string('type')->nullable()->default('text')->index();
            $table->string('from_profile_ids')->nullable();
            $table->boolean('group_message')->default(false);
            $table->boolean('is_hidden')->default(false)->index();
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['to_id', 'from_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direct_messages');
    }
}
