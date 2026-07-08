<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\MaintenanceRecord;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceRecordFactory extends Factory
{
    protected $model = MaintenanceRecord::class;

    public function definition(): array
    {
        return [
            'asset_id' => Asset::factory(),
            'type' => $this->faker->randomElement(array_keys(MaintenanceRecord::TYPES)),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'description' => $this->faker->sentence(),
            'technician' => $this->faker->optional()->name(),
            'supplier_id' => Supplier::factory(),
            'cost' => $this->faker->optional()->randomFloat(2, 50, 5000),
            'started_at' => $this->faker->date(),
            'completed_at' => null,
            'resolution' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function inProgress(): static
    {
        return $this->state([
            'status' => 'in_progress',
            'completed_at' => null,
            'resolution' => null,
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
            'completed_at' => $this->faker->date(),
            'resolution' => $this->faker->sentence(),
        ]);
    }
}
