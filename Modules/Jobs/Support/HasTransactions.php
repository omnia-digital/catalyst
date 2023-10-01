<?php

namespace Modules\Jobs\Support;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Jobs\Models\Transaction;

trait HasTransactions
{
    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
