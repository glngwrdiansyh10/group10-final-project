<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete();
            $table->foreignId('cabang_id')->constrained('cabang')->cascadeOnDelete();
            $table->integer('jumlah')->default(0);
            $table->timestamps();

            $table->unique(['produk_id', 'cabang_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
