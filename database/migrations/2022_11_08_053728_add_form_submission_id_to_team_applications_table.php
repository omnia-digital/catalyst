<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use OmniaDigital\CatalystCore\Models\FormSubmission;

return new class extends Migration
{
    public function up()
    {
        Schema::table('team_applications', function (Blueprint $table) {
            $table->foreignIdFor(FormSubmission::class, 'form_submission_id')->after('role')->nullable();
        });
    }

    public function down()
    {
        Schema::table('team_applications', function (Blueprint $table) {
            $table->dropColumn('form_submission_id');
        });
    }
};
