<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Seed the minimum data required for a real (non-demo) environment.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => env('ADMIN_EMAIL', 'admin@itassets.test'),
        ], [
            'name'     => env('ADMIN_NAME', 'Admin'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);

        Setting::set('base_currency', 'USD');
        Setting::set('display_locale', 'en_US');

        $this->call([
            RoleSeeder::class,
        ]);
    }
}
