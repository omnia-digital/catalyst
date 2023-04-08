<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->morphs('targetable');
            $table->morphs('associatable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('associations');
    }
};
