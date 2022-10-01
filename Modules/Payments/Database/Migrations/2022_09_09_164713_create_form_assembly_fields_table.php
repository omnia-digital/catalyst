<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Payments\Models\FormAssemblyForm;

class CreateFormAssemblyFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_assembly_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FormAssemblyForm::class, 'form_assembly_form_id');
            $table->string('name');
            $table->string('tfa_code');
            $table->boolean('enabled')->default(0);
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
        Schema::dropIfExists('form_assembly_fields');
    }
}
