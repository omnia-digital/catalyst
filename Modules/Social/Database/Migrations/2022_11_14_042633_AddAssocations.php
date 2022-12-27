<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('target_type');
            $table->string('target_id');
            $table->morphs('associatable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associations', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('target_type');
            $table->dropColumn('target_id');
            $table->dropMorphs('associatable');
        });
    }
}
