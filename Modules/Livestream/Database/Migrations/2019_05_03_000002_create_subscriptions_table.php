<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //$table->id();
            $table->foreignId('team_id')->after('name');
            //$table->string('name');
            //$table->string('stripe_id');
            $table->string('stripe_status')->after('team_id');
            //$table->string('stripe_plan')->nullable();
            //$table->integer('quantity')->nullable();
            //$table->timestamp('trial_ends_at')->nullable();
            //$table->timestamp('ends_at')->nullable();
            //$table->timestamps();

            $table->index(['team_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
