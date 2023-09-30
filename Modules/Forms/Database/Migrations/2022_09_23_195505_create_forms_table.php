<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormTemplate;
use Modules\Forms\Models\FormType;

return new class extends Migration {
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
            $table->string('slug');
            $table->string('type')->nullable();
            $table->json('content');
            $table->timestamps();
        });

        Schema::create('form_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->json('content');
            $table->foreignIdFor(FormTemplate::class, 'form_template_id')->index()->nullable();
            $table->foreignIdFor(FormType::class, 'form_type_id')->index()->nullable();
            $table->foreignIdFor(Team::class, 'team_id')->index()->nullable();
            $table->boolean('is_used_on_all_teams')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Form::class, 'form_id')->index();
            $table->foreignIdFor(User::class, 'user_id')->index();
            $table->foreignIdFor(Team::class, 'team_id')->index()->nullable();
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
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('forms');
        Schema::dropIfExists('form_types');
        Schema::dropIfExists('form_templates');
    }
};
