<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResource extends JsonResource
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
            'date' => $this->date->toDateString(),
            'amount' => $this->amount,
            'amount_formatted' => price($this->amount),
            'paid_amount' => $this->paid_amount,
            'paid_amount_formatted' => price($this->paid_amount),
            'paid' => $this->isPaid(),
            'message' => $this->getStatusMessage(),
        ];
    }
}
