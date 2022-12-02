<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Forms\Models\Form;
use Spatie\Permission\Models\Role;

class CreateFormNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Form::class, 'form_id');
            $table->foreignIdFor(Role::class, 'role_id');
            $table->string('target_role')->nullable();
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('timezone')->default('UTC');
            $table->timestamp('send_date');
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
        Schema::dropIfExists('form_notifications');
    }
}
