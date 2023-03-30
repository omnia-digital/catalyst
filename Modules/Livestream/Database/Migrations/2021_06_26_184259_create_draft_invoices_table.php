<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('extra_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\LivestreamAccount::class)->index();
            $table->foreignIdFor(\App\Models\Team::class)->index();
            $table->integer('duration');
            $table->decimal('amount', 14, 2);
            $table->text('billing_reason');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('extra_invoice_items');
    }
}
