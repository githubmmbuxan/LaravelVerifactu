<?php

declare(strict_types=1);

namespace Database\Factories\MMBuxan\VeriFactu\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use MMBuxan\VeriFactu\Models\Breakdown;
use MMBuxan\VeriFactu\Enums\TaxType;
use MMBuxan\VeriFactu\Enums\RegimeType;
use MMBuxan\VeriFactu\Enums\OperationType;

class BreakdownFactory extends Factory
{
    protected $model = Breakdown::class;

    public function definition(): array
    {
        return [
            'tax_type' => $this->faker->randomElement(array_column(TaxType::cases(), 'value')),
            'regime_type' => $this->faker->randomElement(array_column(RegimeType::cases(), 'value')),
            'operation_type' => $this->faker->randomElement(array_column(OperationType::cases(), 'value')),
            'tax_rate' => $this->faker->randomFloat(2, 0, 21),
            'base_amount' => $this->faker->randomFloat(2, 100, 1000),
            'tax_amount' => $this->faker->randomFloat(2, 10, 200),
            'equivalence_surcharge_rate' => $this->faker->optional()->randomFloat(2, 0, 5),
            'equivalence_surcharge_amount' => $this->faker->optional()->randomFloat(2, 0, 50),
            'exemption_code' => $this->faker->optional()->bothify('E#'),
            'exemption_description' => $this->faker->optional()->sentence,
        ];
    }
} 