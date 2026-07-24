<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            AssetCategorySeeder::class,
            SupplierSeeder::class,
            LocationSeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            AssetSeeder::class,
            AssignmentSeeder::class,
            LicenseSeeder::class,
            LicenseAssignmentSeeder::class,
            MaintenanceRecordSeeder::class,
        ]);
    }
}
