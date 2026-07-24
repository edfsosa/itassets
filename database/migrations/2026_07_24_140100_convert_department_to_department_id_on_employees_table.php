<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('department')->constrained('departments')->nullOnDelete();
        });

        DB::table('employees')->whereNotNull('department')->distinct()->pluck('department')
            ->each(function (string $name): void {
                $departmentId = DB::table('departments')->where('name', $name)->value('id');

                if (! $departmentId) {
                    $departmentId = DB::table('departments')->insertGetId([
                        'name' => $name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('employees')->where('department', $name)->update(['department_id' => $departmentId]);
            });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('department')->nullable()->after('status');
        });

        DB::table('employees')->whereNotNull('department_id')->get(['id', 'department_id'])
            ->each(function (object $employee): void {
                $name = DB::table('departments')->where('id', $employee->department_id)->value('name');

                DB::table('employees')->where('id', $employee->id)->update(['department' => $name]);
            });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
        });
    }
};
