<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Subscriptions\Models\SubscriptionType;

class CreateChargentSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargent_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->index()->nullable();
            $table->foreignIdFor(SubscriptionType::class, 'subscription_type_id')->default(1);
            $table->string('chargent_order_id')->nullable();
            $table->string('card_type')->nullable();
            $table->string('last_4')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('last_transaction_at')->nullable();
            $table->timestamp('next_invoice_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('chargent_subscriptions');
    }
}
