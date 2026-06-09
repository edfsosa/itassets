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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique();

            // Información general
            $table->string('name');
            $table->foreignId('asset_category_id')->constrained()->restrictOnDelete();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('status')->default('stock'); // available, assigned, maintenance, retired, stock, lost
            $table->string('condition')->nullable();     // new, good, fair, poor
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();

            // Adquisición
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();

            // Garantía
            $table->date('warranty_expiry_date')->nullable();
            $table->foreignId('warranty_supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
