<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\WalletFilter;
use App\Support\Traits\Selectable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laraeast\LaravelSettings\Facades\Settings;

class Wallet extends Model
{
    use Filterable;
    use Selectable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'name',
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = WalletFilter::class;

    /**
     * Get the model that associated the wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo('model');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'wallet_id');
    }

    public function scopeGroupedByBuilding(Builder $query)
    {
        $data = [];
        foreach (Building::when(auth()->user()->isSupervisor(), function (Builder $query) {
            $query->whereRelation('supervisors', 'id', auth()->id());
        })->get() as $building) {
            $wallets = $building->wallets;
            $ownerWallet = $building->owner->wallet;

            foreach ($wallets as $wallet) {
                $data[$building->name][$wallet->id] = sprintf(
                    '%s (%s : %s %s)',
                    $wallet->name,
                    __('transactions.attributes.balance'),
                    $wallet->transactions->sum('amount'),
                    Settings::get('currency')
                );
            }
            $data[$building->name][$ownerWallet->id] = sprintf(
                '%s (%s : %s %s)',
                $ownerWallet->name,
                __('transactions.attributes.balance'),
                $ownerWallet->transactions->sum('amount'),
                Settings::get('currency')
            );
        }

        return collect($data);
    }
}
