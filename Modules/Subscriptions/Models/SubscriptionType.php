<?php

namespace Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function printAmount()
    {
        return "$" . number_format($this->amount / 100, 2);
    }
}
