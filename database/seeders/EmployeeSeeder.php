<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::pluck('id', 'name');

        $employees = [
            [
                'legajo'          => 'AMP-001',
                'name'            => 'Martín González',
                'document_number' => '1.234.567',
                'email'           => 'martin.gonzalez@itassets.test',
                'phone'           => '+54-11-5555-1001',
                'department_id'   => $departments['Tecnología'],
                'position'        => 'Director de TI',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-002',
                'name'            => 'Sofía Martínez',
                'document_number' => '2.345.678',
                'email'           => 'sofia.martinez@itassets.test',
                'phone'           => '+54-11-5555-1002',
                'department_id'   => $departments['Tecnología'],
                'position'        => 'Administradora de Sistemas',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-003',
                'name'            => 'Diego Rodríguez',
                'document_number' => '3.456.789',
                'email'           => 'diego.rodriguez@itassets.test',
                'phone'           => '+54-11-5555-1003',
                'department_id'   => $departments['Tecnología'],
                'position'        => 'Soporte Técnico',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-004',
                'name'            => 'Valentina Álvarez',
                'document_number' => '4.567.890',
                'email'           => 'valentina.alvarez@itassets.test',
                'phone'           => '+54-11-5555-1004',
                'department_id'   => $departments['Recursos Humanos'],
                'position'        => 'Directora de RRHH',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-005',
                'name'            => 'Joaquín Pérez',
                'document_number' => '5.678.901',
                'email'           => 'joaquin.perez@itassets.test',
                'phone'           => '+54-11-5555-1005',
                'department_id'   => $departments['Recursos Humanos'],
                'position'        => 'Analista de RRHH',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-006',
                'name'            => 'Camila Vargas',
                'document_number' => '6.789.012',
                'email'           => 'camila.vargas@itassets.test',
                'phone'           => '+54-11-5555-1006',
                'department_id'   => $departments['Ventas'],
                'position'        => 'Gerente de Ventas',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-007',
                'name'            => 'Andrés Silva',
                'document_number' => '7.890.123',
                'email'           => 'andres.silva@itassets.test',
                'phone'           => '+54-11-5555-1007',
                'department_id'   => $departments['Ventas'],
                'position'        => 'Ejecutivo de Ventas',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-008',
                'name'            => 'Isabella Rojas',
                'document_number' => '8.901.234',
                'email'           => 'isabella.rojas@itassets.test',
                'phone'           => '+54-11-5555-1008',
                'department_id'   => $departments['Contabilidad'],
                'position'        => 'Contadora Senior',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-009',
                'name'            => 'Santiago Castro',
                'document_number' => '9.012.345',
                'email'           => 'santiago.castro@itassets.test',
                'phone'           => '+54-11-5555-1009',
                'department_id'   => $departments['Contabilidad'],
                'position'        => 'Asistente Contable',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-010',
                'name'            => 'Luciana Fernández',
                'document_number' => '1.012.345',
                'email'           => 'luciana.fernandez@itassets.test',
                'phone'           => '+54-11-5555-1010',
                'department_id'   => $departments['Marketing'],
                'position'        => 'Coordinadora de Marketing',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-011',
                'name'            => 'Matías López',
                'document_number' => '1.123.456',
                'email'           => 'matias.lopez@itassets.test',
                'phone'           => '+54-11-5555-1011',
                'department_id'   => $departments['Marketing'],
                'position'        => 'Diseñador Gráfico',
                'status'          => 'active',
            ],
            [
                'legajo'          => 'AMP-012',
                'name'            => 'Emilia Díaz',
                'document_number' => '1.456.789',
                'email'           => 'emilia.diaz@itassets.test',
                'phone'           => '+54-11-5555-1012',
                'department_id'   => $departments['Operaciones'],
                'position'        => 'Jefa de Operaciones',
                'status'          => 'active',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::firstOrCreate(
                ['legajo' => $employee['legajo']],
                $employee
            );
        }
    }
}
