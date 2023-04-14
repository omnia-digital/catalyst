<?php

namespace Modules\Jobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DownloadInvoiceController extends Controller
{
    public function __invoke($id)
    {
        // One approach is to generate invoices ourselves.
        // The disadvantage is that this doesn't show the Stripe client's billing address.

        // return Auth::user()->downloadInvoice($id, [
        //     'vendor' => 'Foo Inc.',
        //     'product' => 'An Amazing SaaS',
        // ]);

        // For that reason, we use Stripe invoices instead.
        return redirect(auth()->user()->findInvoice($id)->asStripeInvoice()->invoice_pdf);
    }
}
