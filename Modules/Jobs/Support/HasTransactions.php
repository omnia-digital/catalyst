<?php

namespace Modules\Jobs\Support;

use Modules\Jobs\Models\Transaction;

trait HasTransactions
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
