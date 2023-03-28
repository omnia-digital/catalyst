<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('team_plan_prices', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id')->unique();
            $table->foreignIdFor(\App\Models\TeamPlan::class)->index();
            $table->decimal('amount', 14, 2);
            $table->string('billing_period');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_plan_prices');
    }
};
