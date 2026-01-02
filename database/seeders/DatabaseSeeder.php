<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ShopSetting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //Masukkan Akun Admin
        DB::table('users')->insert([
            'nama' => 'Admin',
            'email' => 'admin@teleat.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'no_hp' => '083139821884',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Masukkan Kategori Awal
        DB::table('categories')->insert([
            ['nama_kategori' => 'Makanan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Minuman', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
        ]);

        //Setting Admin
        ShopSetting::create([
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'Tel-Eat Canteen',
        ]);
    }
}
