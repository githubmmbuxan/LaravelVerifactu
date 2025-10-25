<?php

declare(strict_types=1);

namespace Database\Factories\MMBuxan\VeriFactu\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use MMBuxan\VeriFactu\Models\Recipient;

class RecipientFactory extends Factory
{
    protected $model = Recipient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'tax_id' => strtoupper($this->faker->bothify('C########')),
            'country' => $this->faker->countryCode,
            'address' => $this->faker->address,
            'email' => $this->faker->optional()->safeEmail,
            'phone' => $this->faker->optional()->phoneNumber,
            'type' => $this->faker->optional()->randomElement(['VAT', 'PASSPORT', 'NATIONAL_ID', 'RESIDENCE_CERTIFICATE', 'OTHER_DOCUMENT', 'UNREGISTERED']),
        ];
    }
}
