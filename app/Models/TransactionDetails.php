<?php

namespace App\Models;

use App\Casts\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
    ];

    protected $casts = [
        'amount' => Price::class,
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function installment()
    {
        return $this->hasOne(Installment::class, 'transaction_detail_id');
    }
}
