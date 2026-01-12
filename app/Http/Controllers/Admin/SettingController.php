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
        $rekenings = ShopSetting::all();
        return view('admin.settings.index', compact('rekenings'));
    }

    public function store(Request $request)
    {
        // VALIDASI YANG LEBIH PINTAR
        $request->validate([
            'nama_bank' => 'required', // Contoh: "BCA" atau "QRIS Utama"
            // Nomor rekening & Atas nama jadi BOLEH KOSONG (nullable)
            'nomor_rekening' => 'nullable',
            'atas_nama' => 'nullable',
            'foto_qris' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_bank', 'nomor_rekening', 'atas_nama']);

        // Kalau Nomor Rekening kosong, kita isi strip (-) biar database gak error
        // (Kecuali kamu ubah database jadi nullable, tapi ini cara aman tanpa otak-atik database)
        if (!$request->nomor_rekening)
            $data['nomor_rekening'] = '-';
        if (!$request->atas_nama)
            $data['atas_nama'] = '-';

        if ($request->hasFile('foto_qris')) {
            $data['foto_qris'] = $request->file('foto_qris')->store('toko', 'public');
        }

        ShopSetting::create($data);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $rekening = ShopSetting::findOrFail($id);

        $request->validate([
            'nama_bank' => 'required',
            'nomor_rekening' => 'nullable', // Jadi nullable
            'atas_nama' => 'nullable',      // Jadi nullable
            'foto_qris' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_bank', 'nomor_rekening', 'atas_nama']);

        // Default strip kalau kosong
        if (!$request->nomor_rekening)
            $data['nomor_rekening'] = '-';
        if (!$request->atas_nama)
            $data['atas_nama'] = '-';

        if ($request->hasFile('foto_qris')) {
            if ($rekening->foto_qris && Storage::disk('public')->exists($rekening->foto_qris)) {
                Storage::disk('public')->delete($rekening->foto_qris);
            }
            $data['foto_qris'] = $request->file('foto_qris')->store('toko', 'public');
        }

        $rekening->update($data);

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $rekening = ShopSetting::findOrFail($id);
        if ($rekening->foto_qris && Storage::disk('public')->exists($rekening->foto_qris)) {
            Storage::disk('public')->delete($rekening->foto_qris);
        }
        $rekening->delete();
        return back()->with('success', 'Dihapus!');
    }
}
