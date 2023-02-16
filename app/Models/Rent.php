<?php

namespace App\Models;

use App\Casts\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'apartment_id',
        'from',
        'to',
        'renewable',
        'amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',
        'renewable' => 'boolean',
        'amount' => Price::class,
    ];

    /**
     * Retrieve the tenant user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Retrieve the rentable apartment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    /**
     * Scope the query to include rents that overlap the given period.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $from
     * @param string $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereDateRange(Builder $query, string $from, string $to)
    {
        $from = Carbon::createFromFormat('Y-m-d', $from);
        $to = Carbon::createFromFormat('Y-m-d', $to);


        return $query->where(function ($query) use ($from, $to) {
            $query->whereDate('from', '<=', $to);
            $query->whereDate('to', '>=', $from);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastPartiallyOrPaidInstallment()
    {
        return $this->hasOne(Installment::class)->partiallyOrPaid()->latest('id');
    }
}
