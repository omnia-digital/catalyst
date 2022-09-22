<?php

namespace Modules\Subscriptions\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChargentSubscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'starts_at',
        'next_invoice_at',
        'ends_at',
        'last_transaction_at'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Subscriptions\Database\factories\ChargentSubscriptionFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'Recurring';
    }

    public function paymentMethod()
    {
        return ($this->card_type ?? 'Card') . " " . ($this->last_4 ?? 'XXXX');
    }

    public function cardIcon()
    {
        if ($this->card_type) {
            return 'fab-cc-' . strtolower($this->card_type);
        }

        return 'fas-credit-card';
    }
}
