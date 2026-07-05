<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_asset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('charger_serial')->nullable();
            $table->string('ticket_number')->nullable();
            $table->date('assigned_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['assignment_id', 'asset_id']);
        });

        // Migrar datos existentes a la pivote
        DB::table('assignment_asset')->insertUsing(
            ['assignment_id', 'asset_id', 'assigned_at', 'notes', 'created_at', 'updated_at'],
            DB::table('assignments')->select(
                'id as assignment_id',
                'asset_id',
                'assigned_at',
                'notes',
                'created_at',
                'updated_at'
            )
        );

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['asset_id']);
            $table->dropColumn('asset_id');
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('asset_id')->nullable()->after('employee_id')->constrained()->restrictOnDelete();
        });

        // Restaurar el primer asset de cada asignacion
        DB::statement("
            UPDATE assignments a
            SET a.asset_id = (
                SELECT aa.asset_id FROM assignment_asset aa
                WHERE aa.assignment_id = a.id
                ORDER BY aa.id ASC
                LIMIT 1
            )
            WHERE EXISTS (SELECT 1 FROM assignment_asset aa WHERE aa.assignment_id = a.id)
        ");

        Schema::dropIfExists('assignment_asset');
    }
};
