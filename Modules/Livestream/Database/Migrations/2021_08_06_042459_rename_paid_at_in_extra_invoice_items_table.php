<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePaidAtInExtraInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extra_invoice_items', function (Blueprint $table) {
            $table->renameColumn('paid_at', 'added_to_invoice_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extra_invoice_items', function (Blueprint $table) {
            $table->renameColumn('added_to_invoice_at', 'paid_at');
        });
    }
}
