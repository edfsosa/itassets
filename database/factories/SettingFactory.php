<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        $key = $this->faker->unique()->randomElement([
            'exchange_rate', 'company_name', 'pdf_intro', 'pdf_closing',
        ]);

        $value = match ($key) {
            'exchange_rate' => (string) $this->faker->randomFloat(2, 7000, 8000),
            'company_name' => $this->faker->company(),
            default => $this->faker->sentence(),
        };

        return [
            'key' => $key,
            'value' => $value,
        ];
    }

    public function withKey(string $key, mixed $value): static
    {
        return $this->state(compact('key', 'value'));
    }
}
