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
            $table->boolean('is_active')->default(true)->after('status');
        });

        DB::table('employees')->where('status', '!=', 'active')->update(['is_active' => false]);

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('status')->default('active')->after('document_number');
        });

        DB::table('employees')->where('is_active', false)->update(['status' => 'inactive']);

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
