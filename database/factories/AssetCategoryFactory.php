<?php

namespace Database\Factories;

use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetCategoryFactory extends Factory
{
    protected $model = AssetCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' ' . $this->faker->randomElement(['Equipos', 'Accesorios', 'Sistemas']),
            'type' => $this->faker->randomElement(array_keys(AssetCategory::TYPES)),
            'description' => $this->faker->optional()->sentence(),
        ];
    }

    public function hardware(): static
    {
        return $this->state(['type' => 'hardware', 'name' => 'Hardware']);
    }

    public function software(): static
    {
        return $this->state(['type' => 'software', 'name' => 'Software / Licencias']);
    }
}
