<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Forms\Models\FormSubmission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('team_applications', function (Blueprint $table) {
            $table->foreignIdFor(FormSubmission::class, 'form_submission_id')->after('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_applications', function (Blueprint $table) {
            $table->dropColumn('form_submission_id');
        });
    }
};
