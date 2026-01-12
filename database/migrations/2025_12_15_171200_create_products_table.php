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
        Schema::create('products', function (Blueprint $table) {
        $table->id('id_produk');
        $table->foreignId('id_kategori')->constrained('categories', 'id_kategori')->onDelete('cascade');
        $table->string('nama_produk');
        $table->text('deskripsi')->nullable();
        $table->integer('harga');
        $table->integer('stok');
        $table->string('gambar')->nullable();
        $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
