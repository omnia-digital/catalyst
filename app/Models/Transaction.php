<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'description',
        'transaction_id',
        'payer_id',
        'payer_name',
        'payer_email',
        'amount',
        'invoice_number',
        'user_id',
    ];

    /**
     * Get the model that the transaction belongs to.
     */
    public function transactionable()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
