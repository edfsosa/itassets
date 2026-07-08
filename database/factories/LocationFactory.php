<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->city() . ' ' . $this->faker->randomElement(['Oficina', 'Sede', 'Depósito']),
            'building' => $this->faker->optional()->word(),
            'floor' => $this->faker->optional()->randomElement(['PB', 'Piso 1', 'Piso 2', 'Piso 3']),
            'room' => $this->faker->optional()->bothify('###'),
            'notes' => $this->faker->optional()->text(100),
        ];
    }
}
