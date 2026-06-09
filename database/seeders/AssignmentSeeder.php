<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = [
            // Martín González (Director TI) -> Laptop Dell Latitude 1
            [
                'asset_id'    => 1,
                'employee_id' => 1,
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-01-20',
                'returned_at' => null,
                'notes'       => 'Asignación inicial por compra.',
            ],
            // Sofía Martínez (Admin Sistemas) -> Laptop Dell Latitude 2
            [
                'asset_id'    => 2,
                'employee_id' => 2,
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-01-20',
                'returned_at' => null,
                'notes'       => 'Asignación inicial por compra.',
            ],
            // Valentina Álvarez (Dir RRHH) -> Lenovo ThinkPad
            [
                'asset_id'    => 3,
                'employee_id' => 4,
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-02-05',
                'returned_at' => null,
                'notes'       => 'Premium para directora de RRHH.',
            ],
            // Luciana Fernández (Marketing) -> MacBook Pro
            [
                'asset_id'    => 6,
                'employee_id' => 10,
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-03-05',
                'returned_at' => null,
                'notes'       => 'Equipo para diseño gráfico y marketing.',
            ],
            // Andrés Silva (Ventas) -> Smartphone Galaxy S24
            [
                'asset_id'    => 13,
                'employee_id' => 7,
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-03-20',
                'returned_at' => null,
                'notes'       => 'Móvil corporativo para ejecutivo de ventas.',
            ],
            // Diego Rodríguez (Soporte) -> Headset Jabra
            [
                'asset_id'    => 10,
                'employee_id' => 3,
                'assigned_by' => 'Admin',
                'assigned_at' => '2026-04-15',
                'returned_at' => null,
                'notes'       => 'Headset para soporte telefónico.',
            ],
            // Devolución ejemplo: Desktop HP que estaba asignado y se devolvió
            [
                'asset_id'    => 5,
                'employee_id' => 3,
                'assigned_by' => 'Admin',
                'assigned_at' => '2025-09-01',
                'returned_at' => '2026-02-28',
                'notes'       => 'Equipo devuelto por cambio a laptop. Pasó a mantenimiento.',
            ],
        ];

        foreach ($assignments as $assignment) {
            Assignment::create($assignment);
        }
    }
}
