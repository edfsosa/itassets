<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name'     => 'Oficina Central - Piso 1',
                'building' => 'Edificio Corporativo',
                'floor'    => '1',
                'room'     => '101',
                'notes'    => 'Recepcion y sala de estar.',
            ],
            [
                'name'     => 'Oficina Central - Piso 2',
                'building' => 'Edificio Corporativo',
                'floor'    => '2',
                'room'     => '201',
                'notes'    => 'Departamento de TI.',
            ],
            [
                'name'     => 'Oficina Central - Piso 3',
                'building' => 'Edificio Corporativo',
                'floor'    => '3',
                'room'     => '301',
                'notes'    => 'Oficinas administrativas y RH.',
            ],
            [
                'name'     => 'Sucursal Norte',
                'building' => 'Centro Empresarial Norte',
                'floor'    => '5',
                'room'     => '501',
                'notes'    => 'Oficina de ventas región norte.',
            ],
            [
                'name'     => 'Sucursal Sur',
                'building' => 'Torre Sur',
                'floor'    => '10',
                'room'     => '1002',
                'notes'    => 'Oficina de operaciones región sur.',
            ],
            [
                'name'     => 'Almacén Central',
                'building' => 'Depósito Logístico',
                'floor'    => 'PB',
                'room'     => 'A001',
                'notes'    => 'Almacenamiento de equipos nuevos y en reparación.',
            ],
            [
                'name'     => 'Data Center',
                'building' => 'Edificio Corporativo',
                'floor'    => 'Sótano',
                'room'    => 'S-001',
                'notes'    => 'Centro de datos principal, acceso restringido.',
            ],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(
                ['name' => $location['name']],
                $location
            );
        }
    }
}
