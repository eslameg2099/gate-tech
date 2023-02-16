<?php

namespace App\Http\Filters;

use App\Models\User;
use App\Models\Building;
use Illuminate\Database\Eloquent\Builder;

class WalletFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'building_id',
        'selected_id',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where(function (Builder $builder) use ($value) {
                $builder->whereHasMorph(
                    'model',
                    [Building::class],
                    function (Builder $query) use ($value) {
                        $query->whereTranslationLike('name', "%$value%");
                    }
                );

                $builder->orWhereHasMorph(
                    'model',
                    [User::class],
                    function (Builder $query) use ($value) {
                        $query->where('name', 'like', "%$value%");
                    }
                );
                $builder->orWhere([
                    'model_type' => null,
                    'model_id' => null,
                ]);
            });
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given building.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildingId($value)
    {
        if ($value) {
            return $this->builder->where(function (Builder $builder) use ($value) {
                $builder->where([
                    'model_type' => Building::class,
                    'model_id' => $value,
                ]);

                $builder->orWhereHasMorph(
                    'model',
                    [User::class],
                    function (Builder $query) use ($value) {
                        $query->whereRelation('ownedBuildings', 'id', $value);
                    }
                );
                $builder->orWhere([
                    'model_type' => null,
                    'model_id' => null,
                ]);
            });
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
