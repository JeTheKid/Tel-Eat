<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Ini PENTING biar Route Model Binding gak error
    protected $primaryKey = 'id_produk';

    // Kita pakai $fillable biar lebih aman & jelas kolom apa aja yang boleh diisi
    // (Termasuk 'status' yang baru kita tambah)
    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'id_kategori',
        'status'
    ];

    // Relasi: Produk milik satu kategori
    public function category()
    {
        // Pastikan model Category juga sudah ada
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }
}
