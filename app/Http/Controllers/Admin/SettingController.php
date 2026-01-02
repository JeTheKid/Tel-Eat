<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data toko (pasti ada karena tadi sudah kita seed)
        $toko = ShopSetting::first();
        return view('admin.settings.index', compact('toko'));
    }

    public function update(Request $request)
    {
        $toko = ShopSetting::first();

        $request->validate([
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'atas_nama' => 'required',
            'foto_qris' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->only(['nama_bank', 'nomor_rekening', 'atas_nama']);

        // Logic Upload QRIS 📸
        if ($request->hasFile('foto_qris')) {

            // Hapus QRIS lama jika ada
            if ($toko->foto_qris && Storage::disk('public')->exists($toko->foto_qris)) {
                Storage::disk('public')->delete($toko->foto_qris);
            }

            // Simpan yang baru
            $path = $request->file('foto_qris')->store('toko', 'public');
            $data['foto_qris'] = $path;
        }

        $toko->update($data);

        return back()->with('success', 'Pengaturan pembayaran berhasil diupdate!');
    }
}
