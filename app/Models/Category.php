<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id_kategori'; //Custom PK
    protected $guarded = []; // biar bisa diisi semua kolom

    // Relasi: Satu kategori punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class, 'id_kategori');
    }
}
