<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'gateway', 1: 'description', 2: 'transaction_id', 3: 'payer_id', 4: 'payer_name', 5: 'payer_email', 6: 'amount', 7: 'invoice_number', 8: 'user_id'}
     */
    protected $fillable = [
        'gateway',
        'description',
        'transaction_id',
        'payer_id',
        'payer_name',
        'payer_email',
        'amount',
        'invoice_number',
        'user_id'
    ];
}
