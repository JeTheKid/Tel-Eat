<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    // Relasi: Produk milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }
}
