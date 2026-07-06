<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Employee;
use App\Models\License;
use App\Models\LicenseAssignment;
use Illuminate\Database\Seeder;

class LicenseAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $license  = fn (string $name) => License::where('product_name', $name)->first()?->id;
        $asset    = fn (string $tag)   => Asset::where('asset_tag', $tag)->first()?->id;
        $employee = fn (string $legajo) => Employee::where('legajo', $legajo)->first()?->id;

        $assignments = [
            // M365 a empleados
            ['product_name' => 'Microsoft 365 Business Premium', 'asset_tag' => null, 'legajo' => 'AMP-001', 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['product_name' => 'Microsoft 365 Business Premium', 'asset_tag' => null, 'legajo' => 'AMP-002', 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['product_name' => 'Microsoft 365 Business Premium', 'asset_tag' => null, 'legajo' => 'AMP-003', 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['product_name' => 'Microsoft 365 Business Premium', 'asset_tag' => null, 'legajo' => 'AMP-004', 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['product_name' => 'Microsoft 365 Business Premium', 'asset_tag' => null, 'legajo' => 'AMP-006', 'assigned_at' => '2026-01-20', 'released_at' => null],
            // Visual Studio a laptops de TI
            ['product_name' => 'Microsoft Visual Studio Enterprise', 'asset_tag' => 'IT-0001', 'legajo' => null, 'assigned_at' => '2026-01-20', 'released_at' => null],
            // Adobe Creative Cloud a MacBook de Marketing
            ['product_name' => 'Adobe Creative Cloud', 'asset_tag' => 'IT-0006', 'legajo' => null, 'assigned_at' => '2026-03-05', 'released_at' => null],
            // Windows 11 a equipos
            ['product_name' => 'Windows 11 Pro OEM', 'asset_tag' => 'IT-0001', 'legajo' => null, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['product_name' => 'Windows 11 Pro OEM', 'asset_tag' => 'IT-0002', 'legajo' => null, 'assigned_at' => '2026-01-20', 'released_at' => null],
            ['product_name' => 'Windows 11 Pro OEM', 'asset_tag' => 'IT-0003', 'legajo' => null, 'assigned_at' => '2026-02-05', 'released_at' => null],
            ['product_name' => 'Windows 11 Pro OEM', 'asset_tag' => 'IT-0004', 'legajo' => null, 'assigned_at' => '2025-11-25', 'released_at' => null],
            // VMware al Data Center
            ['product_name' => 'VMware vSphere Standard', 'asset_tag' => 'IT-0010', 'legajo' => null, 'assigned_at' => '2025-06-20', 'released_at' => null],
        ];

        foreach ($assignments as $data) {
            LicenseAssignment::create([
                'license_id'  => $license($data['product_name']),
                'asset_id'    => $data['asset_tag'] ? $asset($data['asset_tag']) : null,
                'employee_id' => $data['legajo'] ? $employee($data['legajo']) : null,
                'assigned_at' => $data['assigned_at'],
                'released_at' => $data['released_at'],
            ]);
        }
    }
}
