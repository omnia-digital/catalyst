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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('gateway');
            $table->text('description')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payer_id');
            $table->string('payer_name');
            $table->string('payer_email');
            $table->decimal('amount', 14, 2);
            $table->string('invoice_number')->nullable();
            $table->unsignedBigInteger('transactionable_id')->index();
            $table->string('transactionable_type');
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
        Schema::dropIfExists('transactions');
    }
};
