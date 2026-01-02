<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Tampilkan Halaman Profil
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // Update Data Profil
    public function update(Request $request)
    {
        // 1. Ambil User yang sedang login (Pake id_user)
        $user = \App\Models\User::find(auth()->user()->id_user);

        // 2. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:50',
            'no_hp' => 'required',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 2MB
        ]);

        // 3. Siapkan data yang mau diupdate (Nama & HP dulu)
        $dataToUpdate = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ];

        // 4. Cek: Apakah user upload foto baru?
        if ($request->hasFile('foto_profil')) {

            // Hapus foto lama biar server gak penuh
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru ke folder 'profil' di dalam storage
            $path = $request->file('foto_profil')->store('profil', 'public');

            // Masukkan alamat path tadi ke array data yang mau disimpan
            $dataToUpdate['foto_profil'] = $path;
        }

        // 5. Cek Password (Kalau diisi baru diupdate)
        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }

        // 6. Eksekusi Update ke Database
        $user->update($dataToUpdate);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    //Hapus foto
    public function deletePhoto()
    {
        $user = \App\Models\User::find(auth()->user()->id_user);

        // Hapus file fisik di storage kalo ada
        if ($user->foto_profil) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
        }

        // Set kolom database jadi NULL
        $user->foto_profil = null;
        $user->save();

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }
}
