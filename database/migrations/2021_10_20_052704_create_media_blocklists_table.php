<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaBlocklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_blocklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sha256')->nullable()->unique();
            $table->string('sha512')->nullable()->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true)->index();
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
        Schema::dropIfExists('media_blocklists');
    }
}
