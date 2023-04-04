<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('pt_BR');
        $zip = preg_replace('/[^0-9]/', '', $faker->postCode());

        return [
            'zip_code' => $zip,
            'street' => $faker->streetName(),
            'number' => $faker->randomNumber(3),
            'complement' => $faker->realText(10),
            'neighborhood' => $faker->realText(10),
            'city' => $faker->citySuffix,
            'state' => $faker->stateAbbr,
        ];
    }
}
