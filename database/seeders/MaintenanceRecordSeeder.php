<?php

namespace Database\Seeders;

use App\Models\MaintenanceRecord;
use Illuminate\Database\Seeder;

class MaintenanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'asset_id'     => 5,
                'type'         => 'repair',
                'status'       => 'in_progress',
                'description'  => 'La fuente de poder no enciende. Se reemplazó la fuente pero sigue sin dar video.',
                'technician'   => 'Jorge Castillo',
                'supplier_id'  => 7,
                'cost'         => 150.00,
                'started_at'   => '2026-03-01',
                'completed_at' => null,
                'resolution'   => null,
                'notes'        => 'Pendiente de revisión de la placa madre.',
            ],
            [
                'asset_id'     => 11,
                'type'         => 'preventive',
                'status'       => 'completed',
                'description'  => 'Limpieza general, revisión de ventiladores y actualización de firmware.',
                'technician'   => 'Jorge Castillo',
                'supplier_id'  => 7,
                'cost'         => 200.00,
                'started_at'   => '2026-04-01',
                'completed_at' => '2026-04-02',
                'resolution'   => 'Se realizó limpieza y actualización de firmware. Todo ok.',
                'notes'        => 'Mantenimiento preventivo semestral.',
            ],
            [
                'asset_id'     => 12,
                'type'         => 'preventive',
                'status'       => 'completed',
                'description'  => 'Cambio de baterías y prueba de carga.',
                'technician'   => 'Jorge Castillo',
                'supplier_id'  => 7,
                'cost'         => 80.00,
                'started_at'   => '2026-04-01',
                'completed_at' => '2026-04-01',
                'resolution'   => 'Baterías reemplazadas, prueba de carga exitosa.',
                'notes'        => 'Mantenimiento preventivo semestral.',
            ],
        ];

        foreach ($records as $record) {
            MaintenanceRecord::create($record);
        }
    }
}
