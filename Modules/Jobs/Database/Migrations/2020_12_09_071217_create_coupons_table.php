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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['percent', 'fixed']);
            $table->decimal('discount', 14, 2);
            $table->timestamp('expires_at')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('redeemed_coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id')->index();
            $table->unsignedBigInteger('model_id')->index();
            $table->string('model_type');
            $table->string('code');
            $table->enum('type', ['percent', 'fixed']);
            $table->decimal('original_price', 14, 2);
            $table->decimal('discount_amount', 14, 2);
            $table->decimal('after_discount_price', 14, 2);
            $table->timestamp('redeemed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('redeemed_coupons');
    }
};
