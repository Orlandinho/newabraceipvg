<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'street' => fake()->streetName() . ' ' . mt_rand(10, 1000),
            'region' => array_rand(array_flip(['Jd ', 'Vila ', 'Pq ', 'São ']), 1) . fake()->country(),
            'city' => fake()->city(),
            'zipcode' => '0' . mt_rand(1001, 9990) . mt_rand(00, 99) . '0'
        ];
    }
}
