<?php

namespace Modules\Jobs\Support\Transaction;

use Modules\Jobs\Models\Transaction;

trait HasTransaction
{
    /**
     * Get transactions of a model.
     *
     * @return mixed
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
