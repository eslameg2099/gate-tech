<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
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
            'amount' => $this->amount,
            'amount_formatted' => price($this->amount),
            'tenant' => new CustomerResource($this->tenant),
            'last_installment' => new InstallmentResource($this->lastPartiallyOrPaidInstallment),
        ];
    }
}
