<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'number' => $this->number,
            'date' => $this->date?->format('Y-m-d'),
            'customer_name' => $this->customer_name,
            'customer_tax_id' => $this->customer_tax_id,
            'customer_country' => $this->customer_country,
            'issuer_name' => $this->issuer_name,
            'issuer_tax_id' => $this->issuer_tax_id,
            'issuer_country' => $this->issuer_country,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'total' => $this->total,
            'type' => $this->type,
            'external_reference' => $this->external_reference,
            'description' => $this->description,
            'status' => $this->status,
            'issued_at' => $this->issued_at?->toIso8601String(),
            'cancelled_at' => $this->cancelled_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'breakdowns' => BreakdownResource::collection($this->whenLoaded('breakdowns')),
            'recipients' => RecipientResource::collection($this->whenLoaded('recipients')),
        ];
    }
}
