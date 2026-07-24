<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Tecnología',
            'Recursos Humanos',
            'Ventas',
            'Contabilidad',
            'Marketing',
            'Operaciones',
        ];

        foreach ($departments as $name) {
            Department::firstOrCreate(['name' => $name]);
        }
    }
}
