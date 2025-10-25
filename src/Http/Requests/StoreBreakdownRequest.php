<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use MMBuxan\VeriFactu\Enums\OperationType;
use MMBuxan\VeriFactu\Enums\RegimeType;
use MMBuxan\VeriFactu\Enums\TaxType;

class StoreBreakdownRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'exists:invoices,id'],
            'tax_type' => ['required', Rule::in(array_column(TaxType::cases(), 'value'))],
            'regime_type' => ['required', Rule::in(array_column(RegimeType::cases(), 'value'))],
            'operation_type' => ['required', Rule::in(array_column(OperationType::cases(), 'value'))],
            'tax_rate' => ['required', 'numeric', 'min:0'],
            'base_amount' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['required', 'numeric', 'min:0'],
            'equivalence_surcharge_rate' => ['nullable', 'numeric', 'min:0'],
            'equivalence_surcharge_amount' => ['nullable', 'numeric', 'min:0'],
            'exemption_code' => ['nullable', 'string', 'max:5'],
            'exemption_description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
