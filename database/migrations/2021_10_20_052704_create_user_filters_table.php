<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('filterable_id');
            $table->string('filterable_type');
            $table->string('filter_type')->default('block')->index();
            $table->timestamps();

            $table->unique(['user_id', 'filterable_id', 'filterable_type', 'filter_type'], 'filter_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_filters');
    }
}
