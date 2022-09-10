<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        /** @note We are not using this currently. Save for future when we want teams to create custom plans */
//        Schema::create('stripe_connect_customers', function (Blueprint $table) {
            //$table->id();
            //$table->foreignIdFor(\App\Models\Team::class);
            //$table->foreignIdFor(\App\Models\User::class);
            //$table->string('stripe_customer_id');
            //$table->timestamps();
//        });
    }

    public function down()
    {
//        Schema::dropIfExists('stripe_connect_customers');
    }
};
