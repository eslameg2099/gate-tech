<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'date' => $this->date->toDateTimeString(),
            'amount' => $this->amount,
            'amount_formatted' => price($this->amount),
            'balance' => $this->balance,
            'balance_formatted' => price($this->balance),
            'check_image' => $this->getFirstMediaUrl(),
            'wallet' => new WalletResource($this->wallet),
        ];
    }
}
