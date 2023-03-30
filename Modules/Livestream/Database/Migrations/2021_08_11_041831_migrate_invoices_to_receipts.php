<?php

use Illuminate\Database\Migrations\Migration;

class MigrateInvoicesToReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('invoices')
            ->get()
            ->each(function ($invoice) {
                \Spark\Receipt::create([
                    'team_id' => $invoice->team_id,
                    'provider_id' => $invoice->provider_id,
                    'amount' => $invoice->total,
                    'tax' => $invoice->tax,
                    'paid_at' => $invoice->created_at,
                ]);
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
