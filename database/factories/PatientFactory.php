<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('pt_BR');
        $cns = ['125991883240003', '750807515200018', '736952733670007', '298844931550009', '184208817520018'];

        return [
            'photo' => $faker->filePath(),
            'name' => $faker->name(),
            'mother_name' => $faker->name(),
            'birth' => $faker->date('Y-m-d', now()),
            'cpf' =>  $faker->cpf(false),
            'cns' => $cns[random_int(0, 4)],
        ];
    }
}
