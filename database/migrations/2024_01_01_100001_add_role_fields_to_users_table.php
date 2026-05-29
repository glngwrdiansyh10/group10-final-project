<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['owner', 'manajer', 'supervisor', 'kasir', 'gudang'])
                  ->default('kasir')
                  ->after('name');
            $table->foreignId('cabang_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('cabang')
                  ->nullOnDelete();
            $table->string('telepon', 20)->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('telepon');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cabang_id']);
            $table->dropColumn(['role', 'cabang_id', 'telepon', 'is_active']);
        });
    }
};
