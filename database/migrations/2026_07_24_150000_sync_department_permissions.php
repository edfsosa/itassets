<?php

use Database\Seeders\RoleSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Deploys only run `php artisan migrate --force`, never seeders — so the
     * 'department' permissions added to RoleSeeder's $resources array in the
     * Departments-resource PR never actually got created/synced in
     * production. RoleSeeder::run() is idempotent (firstOrCreate + declarative
     * syncPermissions), so re-running it here via a migration is safe and
     * guarantees it executes wherever migrations do.
     */
    public function up(): void
    {
        (new RoleSeeder())->run();
    }

    public function down(): void
    {
        // No-op: reverting already-granted permissions is not safe/desirable.
    }
};
