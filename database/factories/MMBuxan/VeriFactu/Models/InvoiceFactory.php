<?php

declare(strict_types=1);

namespace Database\Factories\MMBuxan\VeriFactu\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use MMBuxan\VeriFactu\Enums\InvoiceType;
use MMBuxan\VeriFactu\Models\Invoice;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'number' => 'INV-'.$this->faker->unique()->numberBetween(100, 999),
            'date' => $this->faker->date(),
            'customer_name' => $this->faker->company,
            'customer_tax_id' => strtoupper($this->faker->bothify('A########')),
            'customer_country' => $this->faker->countryCode,
            'issuer_name' => $this->faker->company,
            'issuer_tax_id' => strtoupper($this->faker->bothify('B########')),
            'issuer_country' => $this->faker->countryCode,
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'tax' => $this->faker->randomFloat(2, 10, 200),
            'total' => $this->faker->randomFloat(2, 110, 1200),
            'type' => $this->faker->randomElement(array_column(InvoiceType::cases(), 'value')),
            'external_reference' => $this->faker->optional()->bothify('EXT-####'),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'cancelled']),
            'issued_at' => $this->faker->optional()->dateTimeThisYear(),
            'cancelled_at' => null,
        ];
    }
}
