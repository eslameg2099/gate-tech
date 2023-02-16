<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use App\Casts\Price;
use App\Http\Filters\Filterable;
use App\Http\Filters\TransactionFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Transaction extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasUploader;
    use Filterable;

    const CASH_MONEY = 'cash_money';

    const CASH_CHECKS = 'cash_checks';

    const BANK_TRANSFER = 'bank_transfer';

    const VISA = 'visa';

    protected $fillable = [
        'actor_id',
        'wallet_id',
        'amount',
        'balance',
        'notes',
        'model_id',
        'model_type',
        'reason',
        'notes',
        'payment_method',
        'check_number',
        'date',
        'service_id',
    ];

    protected $casts = [
        'amount' => Price::class,
        'balance' => Price::class,
        'date' => 'datetime',
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = TransactionFilter::class;

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function model()
    {
        return $this->morphTo('model');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }

    public static function booted()
    {
        static::saving(function (self $transaction) {
            if (is_null($transaction->date)) {
                $transaction->forceFill(['date' => now()]);
            }
        });

        static::saved(function (self $transaction) {
            $balance = Transaction::where('id', '<=', $transaction->id)
                ->where('wallet_id', $transaction->wallet_id)
                ->sum('amount');

            $transaction->forceFill(compact('balance'))->saveQuietly();
        });
    }

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->singleFile();
    }
}
