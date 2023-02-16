<?php

namespace App\Models\Concerns;

use App\Models\Building;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasWallet
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'model');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wallets()
    {
        return $this->morphMany(Wallet::class, 'model');
    }

    public static function bootHasWallet()
    {
        static::saved(function (self $model) {
            // TODO: needs refactor
            if ($model instanceof Building) {
                $model->wallet()->updateOrCreate([
                    'model_type' => $model->getMorphClass(),
                    'model_id' => $model->getKey(),
                    'name' => 'صندوق شركة الادارة',
                ]);

                $model->wallet()->updateOrCreate([
                    'model_type' => $model->getMorphClass(),
                    'model_id' => $model->getKey(),
                    'name' => 'صندوق البناية',
                ]);
            } else {
                $model->wallet()->updateOrCreate([
                    'model_type' => $model->getMorphClass(),
                    'model_id' => $model->getKey(),
                    'name' => 'صندوق المالك',
                ]);
            }
        });

        static::deleting(function (self $model) {
            if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                if (! $model->forceDeleting) {
                    return;
                }
            }

            $model->wallet()->delete();
        });
    }
}