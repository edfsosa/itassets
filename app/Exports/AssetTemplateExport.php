<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'asset_tag'       => 'IT-0001',
                'nombre'          => 'Laptop HP ProBook 450 G10',
                'categoria'       => 'Hardware',
                'marca'           => 'HP',
                'modelo'          => 'ProBook 450 G10',
                'numero_de_serie' => '5CG1234ABC',
                'estado'          => 'Disponible',
                'empleado_asignado' => '',
                'ubicacion'       => 'Oficina Central',
                'fecha_de_compra' => '15/01/2025',
                'proveedor'       => 'Tech Distribuidora',
                'costo'           => '18500.00',
            ],
            [
                'asset_tag'       => 'IT-0002',
                'nombre'          => 'Monitor Dell 27"',
                'categoria'       => 'Periféricos',
                'marca'           => 'Dell',
                'modelo'          => 'S2722QC',
                'numero_de_serie' => 'DELL98765',
                'estado'          => 'Asignado',
                'empleado_asignado' => 'María García',
                'ubicacion'       => 'Piso 3',
                'fecha_de_compra' => '20/01/2025',
                'proveedor'       => 'CompuWorld',
                'costo'           => '7200.00',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'asset_tag',
            'nombre',
            'categoria',
            'marca',
            'modelo',
            'numero_de_serie',
            'estado',
            'empleado_asignado',
            'ubicacion',
            'fecha_de_compra',
            'proveedor',
            'costo',
        ];
    }
}
