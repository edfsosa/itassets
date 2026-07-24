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

        // MySQL rejects NOT NULL on a column referenced by an ON DELETE SET NULL
        // foreign key, so the constraint has to be dropped and recreated as
        // RESTRICT before the column can be made required. RESTRICT also matches
        // the app's existing behavior: EditDepartment already blocks deleting a
        // department that still has employees.
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable(false)->change();
            $table->string('position')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('email')->nullable()->change();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }
};
