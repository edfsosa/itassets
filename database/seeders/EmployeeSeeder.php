<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'employee_code' => 'EMP-001',
                'name'          => 'Martín González',
                'email'         => 'martin.gonzalez@itassets.test',
                'phone'         => '+54-11-5555-1001',
                'department'    => 'Tecnología',
                'position'      => 'Director de TI',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-002',
                'name'          => 'Sofía Martínez',
                'email'         => 'sofia.martinez@itassets.test',
                'phone'         => '+54-11-5555-1002',
                'department'    => 'Tecnología',
                'position'      => 'Administradora de Sistemas',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-003',
                'name'          => 'Diego Rodríguez',
                'email'         => 'diego.rodriguez@itassets.test',
                'phone'         => '+54-11-5555-1003',
                'department'    => 'Tecnología',
                'position'      => 'Soporte Técnico',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-004',
                'name'          => 'Valentina Álvarez',
                'email'         => 'valentina.alvarez@itassets.test',
                'phone'         => '+54-11-5555-1004',
                'department'    => 'Recursos Humanos',
                'position'      => 'Directora de RRHH',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-005',
                'name'          => 'Joaquín Pérez',
                'email'         => 'joaquin.perez@itassets.test',
                'phone'         => '+54-11-5555-1005',
                'department'    => 'Recursos Humanos',
                'position'      => 'Analista de RRHH',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-006',
                'name'          => 'Camila Vargas',
                'email'         => 'camila.vargas@itassets.test',
                'phone'         => '+54-11-5555-1006',
                'department'    => 'Ventas',
                'position'      => 'Gerente de Ventas',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-007',
                'name'          => 'Andrés Silva',
                'email'         => 'andres.silva@itassets.test',
                'phone'         => '+54-11-5555-1007',
                'department'    => 'Ventas',
                'position'      => 'Ejecutivo de Ventas',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-008',
                'name'          => 'Isabella Rojas',
                'email'         => 'isabella.rojas@itassets.test',
                'phone'         => '+54-11-5555-1008',
                'department'    => 'Contabilidad',
                'position'      => 'Contadora Senior',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-009',
                'name'          => 'Santiago Castro',
                'email'         => 'santiago.castro@itassets.test',
                'phone'         => '+54-11-5555-1009',
                'department'    => 'Contabilidad',
                'position'      => 'Asistente Contable',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-010',
                'name'          => 'Luciana Fernández',
                'email'         => 'luciana.fernandez@itassets.test',
                'phone'         => '+54-11-5555-1010',
                'department'    => 'Marketing',
                'position'      => 'Coordinadora de Marketing',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-011',
                'name'          => 'Matías López',
                'email'         => 'matias.lopez@itassets.test',
                'phone'         => '+54-11-5555-1011',
                'department'    => 'Marketing',
                'position'      => 'Diseñador Gráfico',
                'status'        => 'active',
            ],
            [
                'employee_code' => 'EMP-012',
                'name'          => 'Emilia Díaz',
                'email'         => 'emilia.diaz@itassets.test',
                'phone'         => '+54-11-5555-1012',
                'department'    => 'Operaciones',
                'position'      => 'Jefa de Operaciones',
                'status'        => 'active',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::firstOrCreate(
                ['employee_code' => $employee['employee_code']],
                $employee
            );
        }
    }
}
