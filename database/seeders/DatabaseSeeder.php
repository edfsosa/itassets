<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'     => env('ADMIN_NAME', 'Admin'),
            'email'    => env('ADMIN_EMAIL', 'admin@itassets.test'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);

        $this->call([
            DemoSeeder::class,
        ]);
    }
}
