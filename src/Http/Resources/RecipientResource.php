<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tax_id' => $this->tax_id,
            'country' => $this->country,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'type' => $this->type,
        ];
    }
} 