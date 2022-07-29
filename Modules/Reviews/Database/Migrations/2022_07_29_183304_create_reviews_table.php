<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->index();
            $table->nullableMorphs('reviewable');
            $table->text('body');
            $table->integer('visibility')->default(1);
            $table->foreignIdFor(\App\Models\Language::class, 'language_id')->index()->default(0);
            $table->boolean('received_product_free')->default(false);
            $table->boolean('recommend')->default(false);
            $table->boolean('commentable')->default(true);
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
        Schema::dropIfExists('reviews');
    }
}
