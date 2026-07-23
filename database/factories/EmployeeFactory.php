<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'legajo' => $this->faker->unique()->numerify('EMP-####'),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'department' => $this->faker->randomElement(['TI', 'RRHH', 'Ventas', 'Contabilidad', 'Marketing', 'Operaciones']),
            'position' => $this->faker->jobTitle(),
            'document_number' => $this->faker->unique()->optional()->numerify('########'),
            'status' => 'active',
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => 'inactive']);
    }
}
