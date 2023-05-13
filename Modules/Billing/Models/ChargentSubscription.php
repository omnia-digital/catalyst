<?php

namespace Modules\Billing\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargentSubscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'starts_at',
        'next_invoice_at',
        'ends_at',
        'last_transaction_at',
    ];

    protected static function newFactory()
    {
        return \Modules\Billing\Database\factories\ChargentSubscriptionFactory::new();
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
}
