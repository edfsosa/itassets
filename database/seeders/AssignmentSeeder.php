<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Assignment;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $employee = fn (string $legajo) => Employee::where('legajo', $legajo)->first()?->id;
        $asset    = fn (string $tag)    => Asset::where('asset_tag', $tag)->first()?->id;

        $assignments = [
            // Martín González (Director TI) -> Laptop Dell Latitude 1
            [
                'asset_tag'   => 'IT-0001',
                'legajo'      => 'AMP-001',
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-01-20',
                'returned_at' => null,
                'notes'       => 'Asignación inicial por compra.',
            ],
            // Sofía Martínez (Admin Sistemas) -> Laptop Dell Latitude 2
            [
                'asset_tag'   => 'IT-0002',
                'legajo'      => 'AMP-002',
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-01-20',
                'returned_at' => null,
                'notes'       => 'Asignación inicial por compra.',
            ],
            // Valentina Álvarez (Dir RRHH) -> Lenovo ThinkPad
            [
                'asset_tag'   => 'IT-0003',
                'legajo'      => 'AMP-004',
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-02-05',
                'returned_at' => null,
                'notes'       => 'Premium para directora de RRHH.',
            ],
            // Luciana Fernández (Marketing) -> MacBook Pro
            [
                'asset_tag'   => 'IT-0006',
                'legajo'      => 'AMP-010',
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-03-05',
                'returned_at' => null,
                'notes'       => 'Equipo para diseño gráfico y marketing.',
            ],
            // Andrés Silva (Ventas) -> Smartphone Galaxy S24
            [
                'asset_tag'   => 'IT-0012',
                'legajo'      => 'AMP-007',
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-03-20',
                'returned_at' => null,
                'notes'       => 'Móvil corporativo para ejecutivo de ventas.',
            ],
            // Diego Rodríguez (Soporte) -> Headset Jabra
            [
                'asset_tag'   => 'IT-0009',
                'legajo'      => 'AMP-003',
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-04-15',
                'returned_at' => null,
                'notes'       => 'Headset para soporte telefónico.',
            ],
            // Devolución ejemplo: Desktop HP que estaba asignado y se devolvió
            [
                'asset_tag'   => 'IT-0005',
                'legajo'      => 'AMP-003',
                'assigned_by' => 'Admin',
                'assigned_at' => '2025-09-01',
                'returned_at' => '2026-02-28',
                'notes'       => 'Equipo devuelto por cambio a laptop. Pasó a mantenimiento.',
            ],
        ];

        foreach ($assignments as $data) {
            $assetId  = $asset($data['asset_tag']);
            $data['employee_id'] = $employee($data['legajo']);
            unset($data['asset_tag'], $data['legajo']);

            $assignment = Assignment::create($data);
            $assignment->assets()->attach($assetId, [
                'assigned_at' => $assignment->assigned_at,
            ]);
        }
    }
}
