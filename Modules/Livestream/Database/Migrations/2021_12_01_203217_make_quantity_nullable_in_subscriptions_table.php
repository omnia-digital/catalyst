<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->change();
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->change();
        });
    }

    public function down()
    {
    }
};
