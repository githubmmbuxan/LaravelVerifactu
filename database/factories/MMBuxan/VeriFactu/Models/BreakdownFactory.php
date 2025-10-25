<?php

declare(strict_types=1);

namespace Database\Factories\MMBuxan\VeriFactu\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use MMBuxan\VeriFactu\Enums\OperationTypeEnum;
use MMBuxan\VeriFactu\Enums\RegimeTypeEnum;
use MMBuxan\VeriFactu\Enums\TaxTypeEnum;
use MMBuxan\VeriFactu\Models\Breakdown;

class BreakdownFactory extends Factory
{
    protected $model = Breakdown::class;

    public function definition(): array
    {
        // Base y tasa primero
        $baseAmount = $this->faker->randomFloat(2, 100, 1000);
        $taxRate = $this->faker->randomElement([0.00, 4.00, 10.00, 21.00]); // tasas reales del IVA en España

        // Impuesto coherente
        $taxAmount = round($baseAmount * ($taxRate / 100), 2);

        // Recargo de equivalencia sólo en ciertos casos
        $hasEquivalence = $this->faker->boolean(20); // 20% de probabilidad
        $equivalenceRate = $hasEquivalence ? $this->faker->randomElement([0.5, 1.4, 5.2]) : null;
        $equivalenceAmount = $equivalenceRate ? round($baseAmount * ($equivalenceRate / 100), 2) : null;

        // Exención solo si tax_rate es 0
        $exemptionCode = ($taxRate === 0.00) ? $this->faker->bothify('E#') : null;
        $exemptionDescription = $exemptionCode ? $this->faker->sentence : null;

        return [
            'tax_type' => TaxTypeEnum::VAT->value, // o usa randomElement si necesitas otros
            'regime_type' => RegimeTypeEnum::GENERAL->value,
            'operation_type' => OperationTypeEnum::SUBJECT_NO_EXEMPT_NO_REVERSE->value,
            'tax_rate' => $taxRate,
            'base_amount' => $baseAmount,
            'tax_amount' => $taxAmount, // ✅ coherente
            'equivalence_surcharge_rate' => $equivalenceRate,
            'equivalence_surcharge_amount' => $equivalenceAmount,
            'exemption_code' => $exemptionCode,
            'exemption_description' => $exemptionDescription,
        ];
    }
}
