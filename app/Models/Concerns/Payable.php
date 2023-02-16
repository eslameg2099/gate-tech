<?php

namespace App\Models\Concerns;

use App\Models\Transaction;

trait Payable
{
    public function transactions()
    {
        return $this->morphMany('model', Transaction::class);
    }
}