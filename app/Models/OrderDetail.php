<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'id_detail';
    protected $guarded = ['id_detail'];

    // Relasi ke Produk
    public function product() {
        // Asumsi tabel products primary key-nya 'id' atau 'id_produk' (sesuaikan migration produkmu)
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
}
