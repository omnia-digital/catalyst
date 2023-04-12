<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtraInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'livestream_account_id',
        'duration',
        'amount',
        'billing_reason',
        'paid_at',
    ];

    protected $casts = [
        'added_to_invoice_at' => 'datetime',
    ];

    /**
     * Get extra invoices of the current month.
     *
     * @return Builder
     */
    public function scopeCurrentMonth(Builder $query)
    {
        return $query
            ->whereMonth('created_at', now())
            ->whereYear('created_at', now());
    }

    public function scopeUnpaid(Builder $query)
    {
        return $query->whereNull('added_to_invoice_at');
    }

    public function livestreamAccount(): BelongsTo
    {
        return $this->belongsTo(LivestreamAccount::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
