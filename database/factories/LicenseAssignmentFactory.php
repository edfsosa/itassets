<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Employee;
use App\Models\License;
use App\Models\LicenseAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseAssignmentFactory extends Factory
{
    protected $model = LicenseAssignment::class;

    public function definition(): array
    {
        return [
            'license_id' => License::factory(),
            'asset_id' => Asset::factory(),
            'employee_id' => null,
            'assigned_at' => $this->faker->date(),
            'released_at' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function toEmployee(): static
    {
        return $this->state([
            'asset_id' => null,
            'employee_id' => Employee::factory(),
        ]);
    }

    public function released(): static
    {
        return $this->state(['released_at' => $this->faker->date()]);
    }
}
