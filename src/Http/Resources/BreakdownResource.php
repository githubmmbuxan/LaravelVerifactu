<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BreakdownResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tax_type' => $this->tax_type,
            'regime_type' => $this->regime_type,
            'operation_type' => $this->operation_type,
            'tax_rate' => $this->tax_rate,
            'base_amount' => $this->base_amount,
            'tax_amount' => $this->tax_amount,
            'equivalence_surcharge_rate' => $this->equivalence_surcharge_rate,
            'equivalence_surcharge_amount' => $this->equivalence_surcharge_amount,
            'exemption_code' => $this->exemption_code,
            'exemption_description' => $this->exemption_description,
        ];
    }
}
