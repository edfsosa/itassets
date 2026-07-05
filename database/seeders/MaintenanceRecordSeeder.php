<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\MaintenanceRecord;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class MaintenanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        $asset    = fn (string $tag)  => Asset::where('asset_tag', $tag)->first()->id;
        $supplier = fn (string $name) => Supplier::where('name', $name)->first()->id;

        $records = [
            [
                'asset_tag'    => 'IT-0005',
                'type'         => 'repair',
                'status'       => 'in_progress',
                'description'  => 'La fuente de poder no enciende. Se reemplazó la fuente pero sigue sin dar video.',
                'technician'   => 'Jorge Castillo',
                'supplier_name' => 'ServiTec S.A.',
                'cost'         => 150.00,
                'started_at'   => '2026-03-01',
                'completed_at' => null,
                'resolution'   => null,
                'notes'        => 'Pendiente de revisión de la placa madre.',
            ],
            [
                'asset_tag'    => 'IT-0011',
                'type'         => 'preventive',
                'status'       => 'completed',
                'description'  => 'Limpieza general, revisión de ventiladores y actualización de firmware.',
                'technician'   => 'Jorge Castillo',
                'supplier_name' => 'ServiTec S.A.',
                'cost'         => 200.00,
                'started_at'   => '2026-04-01',
                'completed_at' => '2026-04-02',
                'resolution'   => 'Se realizó limpieza y actualización de firmware. Todo ok.',
                'notes'        => 'Mantenimiento preventivo semestral.',
            ],
            [
                'asset_tag'    => 'IT-0012',
                'type'         => 'preventive',
                'status'       => 'completed',
                'description'  => 'Cambio de baterías y prueba de carga.',
                'technician'   => 'Jorge Castillo',
                'supplier_name' => 'ServiTec S.A.',
                'cost'         => 80.00,
                'started_at'   => '2026-04-01',
                'completed_at' => '2026-04-01',
                'resolution'   => 'Baterías reemplazadas, prueba de carga exitosa.',
                'notes'        => 'Mantenimiento preventivo semestral.',
            ],
        ];

        foreach ($records as $data) {
            MaintenanceRecord::create([
                'asset_id'     => $asset($data['asset_tag']),
                'type'         => $data['type'],
                'status'       => $data['status'],
                'description'  => $data['description'],
                'technician'   => $data['technician'],
                'supplier_id'  => $supplier($data['supplier_name']),
                'cost'         => $data['cost'],
                'started_at'   => $data['started_at'],
                'completed_at' => $data['completed_at'],
                'resolution'   => $data['resolution'],
                'notes'        => $data['notes'],
            ]);
        }
    }
}
