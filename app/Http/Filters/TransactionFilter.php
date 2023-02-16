<?php

namespace App\Http\Filters;

use App\Models\Building;
use App\Models\Rent;

class TransactionFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'reason',
        'type',
        'wallet_id',
        'payment_method',
        'selected_id',
        'year',
    ];

    /**
     * Filter the query by a given reason.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function reason($value)
    {
        if ($value) {
            return $this->builder->where('reason', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given payment method.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function paymentMethod($value)
    {
        if ($value) {
            return $this->builder->where('payment_method', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given year.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function year($value)
    {
        if ($value) {
            return $this->builder->whereYear('date', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given wallet.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function walletId($value)
    {
        if ($value) {
            return $this->builder->where('wallet_id', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given type.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($value)
    {
        switch ($value) {
            case 'deposits':
                return $this->builder->where('amount', '>', 0);
            case 'expenses':
                return $this->builder;
        }

        return $this->builder;
    }

    /**
     * Sorting results by the given id.
     *
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function selectedId($value)
    {
        if ($value) {
            $this->builder->sortingByIds($value);
        }

        return $this->builder;
    }
}
