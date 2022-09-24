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
        Schema::create('form_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->json('content');
            $table->timestamps();
        });

        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->json('content');
            $table->foreignIdFor(\Modules\Forms\Models\FormTemplate::class, 'form_template_id')->index()->nullable();
            $table->foreignIdFor(\App\Models\Team::class, 'team_id')->index()->nullable();
            $table->boolean('is_used_on_all_teams')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Forms\Models\Form::class, 'form_id')->index();
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->index();
            $table->foreignIdFor(\App\Models\Team::class, 'team_id')->index()->nullable();
            $table->json('data');
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
        Schema::dropIfExists('form_templates');
        Schema::dropIfExists('forms');
        Schema::dropIfExists('form_submissions');
    }
};
