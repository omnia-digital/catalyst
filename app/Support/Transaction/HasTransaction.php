<?php

namespace App\Support\Transaction;

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
