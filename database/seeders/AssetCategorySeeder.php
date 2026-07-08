<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Hardware',
                'description' => 'Equipos de cómputo: laptops, PCs, servidores y hardware físico en general.',
            ],
            [
                'name'        => 'Software / Licencias',
                'description' => 'Licencias de software, aplicaciones y suscripciones digitales.',
            ],
            [
                'name'        => 'Periféricos',
                'description' => 'Accesorios y periféricos: teclados, ratones, monitores, headsets, etc.',
            ],
            [
                'name'        => 'Infraestructura',
                'description' => 'Equipos de red y telecomunicaciones: switches, routers, access points, UPS.',
            ],
            [
                'name'        => 'Dispositivos Móviles',
                'description' => 'Smartphones y tablets corporativos.',
            ],
        ];

        foreach ($categories as $category) {
            AssetCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
