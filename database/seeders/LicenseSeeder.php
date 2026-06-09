<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    public function run(): void
    {
        $licenses = [
            [
                'product_name'  => 'Microsoft 365 Business Premium',
                'license_type'  => 'subscription',
                'license_key'   => 'XXXXX-XXXXX-XXXXX-XXXXX-001',
                'total_seats'   => 50,
                'purchase_date' => '2026-01-01',
                'expiry_date'   => '2027-01-01',
                'purchase_price' => 12000.00,
                'supplier_id'   => 5,
                'notes'         => 'Suscripción anual para todo el personal.',
            ],
            [
                'product_name'  => 'Microsoft Visual Studio Enterprise',
                'license_type'  => 'subscription',
                'license_key'   => 'XXXXX-XXXXX-XXXXX-XXXXX-002',
                'total_seats'   => 5,
                'purchase_date' => '2026-01-01',
                'expiry_date'   => '2027-01-01',
                'purchase_price' => 3000.00,
                'supplier_id'   => 5,
                'notes'         => 'Licencias para el equipo de desarrollo.',
            ],
            [
                'product_name'  => 'Adobe Creative Cloud',
                'license_type'  => 'subscription',
                'license_key'   => 'XXXXX-XXXXX-XXXXX-XXXXX-003',
                'total_seats'   => 3,
                'purchase_date' => '2026-01-15',
                'expiry_date'   => '2027-01-15',
                'purchase_price' => 1800.00,
                'supplier_id'   => 5,
                'notes'         => 'Suite completa para el equipo de marketing.',
            ],
            [
                'product_name'  => 'JetBrains All Products Pack',
                'license_type'  => 'subscription',
                'license_key'   => 'XXXXX-XXXXX-XXXXX-XXXXX-004',
                'total_seats'   => 3,
                'purchase_date' => '2026-02-01',
                'expiry_date'   => '2027-02-01',
                'purchase_price' => 900.00,
                'supplier_id'   => 5,
                'notes'         => 'IDE licenses para el equipo de desarrollo.',
            ],
            [
                'product_name'  => 'Windows 11 Pro OEM',
                'license_type'  => 'per_device',
                'license_key'   => 'XXXXX-XXXXX-XXXXX-XXXXX-005',
                'total_seats'   => 20,
                'purchase_date' => '2026-01-15',
                'expiry_date'   => null,
                'purchase_price' => 3000.00,
                'supplier_id'   => 5,
                'notes'         => 'Licencias OEM para equipos nuevos.',
            ],
            [
                'product_name'  => 'Slack Enterprise Grid',
                'license_type'  => 'subscription',
                'license_key'   => null,
                'total_seats'   => 100,
                'purchase_date' => '2026-03-01',
                'expiry_date'   => '2027-03-01',
                'purchase_price' => 8000.00,
                'supplier_id'   => 5,
                'notes'         => 'Plan enterprise para toda la organización.',
            ],
            [
                'product_name'  => 'VMware vSphere Standard',
                'license_type'  => 'perpetual',
                'license_key'   => 'XXXXX-XXXXX-XXXXX-XXXXX-006',
                'total_seats'   => 4,
                'purchase_date' => '2025-06-01',
                'expiry_date'   => null,
                'purchase_price' => 2500.00,
                'supplier_id'   => 5,
                'notes'         => 'Licencia perpetua para 4 sockets del Data Center.',
            ],
        ];

        foreach ($licenses as $license) {
            License::firstOrCreate(
                ['product_name' => $license['product_name']],
                $license
            );
        }
    }
}
