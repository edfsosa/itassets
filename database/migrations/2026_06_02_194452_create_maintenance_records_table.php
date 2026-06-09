<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('type');       // repair, preventive, warranty, upgrade, other
            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->text('description');
            $table->string('technician')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('cost', 10, 2)->nullable();
            $table->date('started_at');
            $table->date('completed_at')->nullable();
            $table->text('resolution')->nullable(); // qué se hizo / diagnóstico final
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
};
