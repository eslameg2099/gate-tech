<?php

namespace App\Models;

use App\Casts\Price;
use App\Models\Concerns\Payable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;
    use Payable;

    protected $fillable = [
        'rent_id',
        'date',
        'amount',
        'paid_amount',
        'transaction_detail_id',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'amount' => Price::class,
        'paid_amount' => Price::class,
    ];

    protected $appends = [
        'remaining_amount'
    ];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetails::class, 'transaction_detail_id');
    }

    public function isPaid(): bool
    {
        return ((int) $this->remaining_amount) === 0;
    }
    public function isUnpaid(): bool
    {
        return  ! $this->paid_amount;
    }

    public function isPartiallyPaid(): bool
    {
        return  $this->paid_amount && $this->paid_amount < $this->amount;
    }

    public function scopeUnpaid($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('paid_amount');
        });
    }
    public function scopePartiallyPaid($query)
    {
        return $query->where(function ($query) {
            $query->whereColumn('paid_amount', '<', 'amount');
        });
    }

    public function scopePartiallyOrUnpaid($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('paid_amount');
            $query->orWhereColumn('paid_amount', '<', 'amount');
        });
    }

    public function scopePaid($query)
    {
        return $query->where(function ($query) {
            $query->whereColumn('paid_amount', 'amount');
        });
    }

    public function scopePartiallyOrPaid($query)
    {
        return $query->where(function ($query) {
            $query->whereNotNull('paid_amount');
            $query->whereColumn('paid_amount', '<=', 'amount');
        });
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    public function getStatusMessage()
    {
        if ($this->isPaid()) {
            return __('اخر ايجار تم دفعه كاملاً لشهر :date', [
                'date' => $this->date->format('Y/m'),
            ]);
        }

        if ($this->isPartiallyPaid()) {
            return __('اخر ايجار تم دفعه جزئيأ بمبلغ :paid_amount لشهر :date', [
                'paid_amount' => price($this->paid_amount),
                'date' => $this->date->format('Y/m'),
            ]);
        }

        return __('لم يقم بالدفع حتى الان');
    }
}
