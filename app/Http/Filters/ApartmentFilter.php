<?php

namespace App\Http\Filters;

class ApartmentFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'number',
        'floor',
        'building_id',
        'has_tenant',
        'selected_id',
    ];

    /**
     * Filter the query by a given number.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function number($value)
    {
        if ($value) {
            return $this->builder->where('number', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given floor.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function floor($value)
    {
        if ($value) {
            return $this->builder->where('floor', $value);
        }

        return $this->builder;
    }
    /**
     * Filter the query by a given building_id.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildingId($value)
    {
        if ($value) {
            return $this->builder->where('building_id', $value);
        }

        return $this->builder;
    }

    /**
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function hasTenant($value)
    {
        if ($value) {
            return $this->builder->has('tenant')->with('tenant');
        }

        return $this->builder->with('tenant');
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
