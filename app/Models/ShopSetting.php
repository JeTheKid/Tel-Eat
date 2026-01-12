<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    use HasFactory;

    protected $table = 'shop_settings';

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'foto_qris'
    ];
}
