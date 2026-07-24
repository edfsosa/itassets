<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('employees')->whereNull('legajo')->get(['id'])->each(function (object $employee): void {
            DB::table('employees')->where('id', $employee->id)->update(['legajo' => 'PENDIENTE-' . $employee->id]);
        });

        DB::table('employees')->whereNull('document_number')->get(['id'])->each(function (object $employee): void {
            DB::table('employees')->where('id', $employee->id)->update(['document_number' => 'PENDIENTE-' . $employee->id]);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('legajo')->nullable(false)->change();
            $table->string('document_number')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('legajo')->nullable()->change();
            $table->string('document_number')->nullable()->change();
        });
    }
};
