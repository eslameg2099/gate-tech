<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => sprintf(
                '%s (%s : %s %s)',
                $this->name,
                __('transactions.attributes.balance'),
                $this->transactions->sum('amount'),
                Settings::get('currency')
            ),
        ];
    }
}
