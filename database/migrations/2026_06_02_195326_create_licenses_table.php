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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('license_type');  // perpetual, subscription, per_device, per_user, concurrent
            $table->string('license_key')->nullable();
            $table->unsignedInteger('total_seats')->default(1);
            $table->date('purchase_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
