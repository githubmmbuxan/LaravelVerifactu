<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'exists:invoices,id'],
            'name' => ['required', 'string', 'max:120'],
            'tax_id' => ['required', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'size:2'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'type' => ['nullable', 'string', 'max:10'],
        ];
    }
}
