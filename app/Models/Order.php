<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 1. Kasih tau nama tabel & primary key
    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    // 2. Izinkan kolom ini diisi massal
    protected $guarded = ['id_order'];

    // 3. Relasi ke User (Foreign Key: id_user)
    public function user() {
        // belongsTo(Model, Foreign_Key_di_tabel_ini, Primary_Key_di_tabel_sana)
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // 4. Relasi ke Detail (Foreign Key: id_order)
    public function details() {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
