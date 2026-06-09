<?php

namespace Database\Seeders;

use App\Models\LicenseAssignment;
use Illuminate\Database\Seeder;

class LicenseAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = [
            // M365 a empleados
            ['license_id' => 1, 'asset_id' => null, 'employee_id' => 1, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['license_id' => 1, 'asset_id' => null, 'employee_id' => 2, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['license_id' => 1, 'asset_id' => null, 'employee_id' => 3, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['license_id' => 1, 'asset_id' => null, 'employee_id' => 4, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['license_id' => 1, 'asset_id' => null, 'employee_id' => 6, 'assigned_at' => '2026-01-20', 'released_at' => null],
            // Visual Studio a laptops de TI
            ['license_id' => 2, 'asset_id' => 1, 'employee_id' => null, 'assigned_at' => '2026-01-20', 'released_at' => null],
            // Adobe Creative Cloud a MacBook de Marketing
            ['license_id' => 3, 'asset_id' => 6, 'employee_id' => null, 'assigned_at' => '2026-03-05', 'released_at' => null],
            // Windows 11 a equipos
            ['license_id' => 5, 'asset_id' => 1, 'employee_id' => null, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['license_id' => 5, 'asset_id' => 2, 'employee_id' => null, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['license_id' => 5, 'asset_id' => 3, 'employee_id' => null, 'assigned_at' => '2026-02-05', 'released_at' => null],
            ['license_id' => 5, 'asset_id' => 4, 'employee_id' => null, 'assigned_at' => '2025-11-25', 'released_at' => null],
            // VMware al Data Center
            ['license_id' => 7, 'asset_id' => 11, 'employee_id' => null, 'assigned_at' => '2025-06-20', 'released_at' => null],
        ];

        foreach ($assignments as $assignment) {
            LicenseAssignment::create($assignment);
        }
    }
}
