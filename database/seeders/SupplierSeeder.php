<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name'         => 'Dell Technologies',
                'contact_name' => 'Carlos Mendoza',
                'email'        => 'carlos.mendoza@dell.com',
                'phone'        => '+1-800-555-0101',
                'website'      => 'https://www.dell.com',
                'notes'        => 'Proveedor principal de laptops y servidores.',
            ],
            [
                'name'         => 'HP Inc.',
                'contact_name' => 'Ana López',
                'email'        => 'ana.lopez@hp.com',
                'phone'        => '+1-800-555-0102',
                'website'      => 'https://www.hp.com',
                'notes'        => 'Impresoras y equipos de escritorio.',
            ],
            [
                'name'         => 'Lenovo',
                'contact_name' => 'Pedro Ramírez',
                'email'        => 'pedro.ramirez@lenovo.com',
                'phone'        => '+1-800-555-0103',
                'website'      => 'https://www.lenovo.com',
                'notes'        => 'Laptops ThinkPad y tablets.',
            ],
            [
                'name'         => 'Cisco Systems',
                'contact_name' => 'María Torres',
                'email'        => 'maria.torres@cisco.com',
                'phone'        => '+1-800-555-0104',
                'website'      => 'https://www.cisco.com',
                'notes'        => 'Equipos de red: switches, routers, access points.',
            ],
            [
                'name'         => 'Microsoft Licensing',
                'contact_name' => 'Laura Gómez',
                'email'        => 'laura.gomez@microsoft.com',
                'phone'        => '+1-800-555-0105',
                'website'      => 'https://www.microsoft.com',
                'notes'        => 'Licencias de software corporativas.',
            ],
            [
                'name'         => 'TechData Solutions',
                'contact_name' => 'Roberto Díaz',
                'email'        => 'roberto.diaz@techdata.com',
                'phone'        => '+1-800-555-0106',
                'website'      => 'https://www.techdata.com',
                'notes'        => 'Distribuidor de periféricos y accesorios.',
            ],
            [
                'name'         => 'ServiTec S.A.',
                'contact_name' => 'Jorge Castillo',
                'email'        => 'jorge.castillo@servitec.com',
                'phone'        => '+54-11-5555-0201',
                'website'      => 'https://www.servitec.com',
                'notes'        => 'Servicio técnico y mantenimiento preventivo.',
            ],
            [
                'name'         => 'Samsung Electronics',
                'contact_name' => 'Lucía Fernández',
                'email'        => 'lucia.fernandez@samsung.com',
                'phone'        => '+1-800-555-0107',
                'website'      => 'https://www.samsung.com',
                'notes'        => 'Monitores, smartphones y tablets.',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}
