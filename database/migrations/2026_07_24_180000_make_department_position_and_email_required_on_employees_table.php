<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $departmentId = DB::table('departments')->where('name', 'Sin asignar')->value('id');

        if (! $departmentId) {
            $departmentId = DB::table('departments')->insertGetId([
                'name' => 'Sin asignar',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('employees')->whereNull('department_id')->update(['department_id' => $departmentId]);

        DB::table('employees')->whereNull('position')->update(['position' => 'Pendiente']);

        DB::table('employees')->whereNull('email')->get(['id'])->each(function (object $employee): void {
            DB::table('employees')->where('id', $employee->id)->update([
                'email' => 'pendiente-' . $employee->id . '@pendiente.itassets.test',
            ]);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable(false)->change();
            $table->string('position')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }
};
