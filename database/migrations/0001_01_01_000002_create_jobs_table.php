<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'role')) {
            $table->enum('role', ['owner', 'manajer', 'supervisor', 'kasir', 'gudang'])
                  ->default('kasir')
                  ->after('name');
        }

        if (!Schema::hasColumn('users', 'cabang_id')) {
            $table->foreignId('cabang_id')
                  ->nullable()
                  ->constrained('cabang')
                  ->nullOnDelete();
        }

        if (!Schema::hasColumn('users', 'telepon')) {
            $table->string('telepon', 20)
                  ->nullable()
                  ->after('email');
        }

        if (!Schema::hasColumn('users', 'is_active')) {
            $table->boolean('is_active')
                  ->default(true)
                  ->after('telepon');
        }
    });
}
};