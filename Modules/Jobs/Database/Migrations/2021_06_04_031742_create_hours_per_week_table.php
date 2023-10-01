<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Jobs\Models\HoursPerWeek;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours_per_week', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::table('job_positions', function (Blueprint $table) {
            $table->foreignIdFor(HoursPerWeek::class, 'hours_per_week_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hours_per_week');

        Schema::table('job_positions', function (Blueprint $table) {
            $table
                ->string('hours_per_week')
                ->after('location')
                ->nullable();
            $table->dropColumn('hours_per_week_id');
        });
    }
};
