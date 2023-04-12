<?php

namespace Modules\Jobs\Data;

use Spatie\DataTransferObject\DataTransferObject;

class Transaction extends DataTransferObject
{
    public string $gateway;

    public ?string $description;

    public ?string $transaction_id;

    public string $payer_id;

    public string $payer_name;

    public string $payer_email;

    public float $amount;

    public ?string $invoice_number;

    public int $user_id;
}
