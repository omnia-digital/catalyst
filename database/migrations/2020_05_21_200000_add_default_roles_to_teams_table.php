<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        if (Schema::hasTable('teams')) {
//            Schema::table('teams', function (Blueprint $table) {
//                $table->unsignedBigInteger('default_role_id')->nullable();
//                $table->foreign('default_role_id')->references('id')->on('roles');
//            });
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('teams')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->dropForeign(['default_role_id']);
                $table->dropColumn('default_role_id');
            });
        }
    }
};
