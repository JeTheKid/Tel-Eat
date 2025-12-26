<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //CEK ROLE USER
            $user = auth()->user();

            if ($user->role === 'admin') {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('katalog'); // Mahasiswa dilempar ke sini
            }
        }

        // Login Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    // 1. Tampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 2. Proses Simpan User Baru
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users', // Email gaboleh kembar
            'no_hp' => 'required|numeric',
            'password' => 'required|min:6',
        ]);

        // Buat User Baru (Otomatis jadi Mahasiswa)
        \App\Models\User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'password' => bcrypt($validated['password']), // Enkripsi password
            'role' => 'mahasiswa', //
        ]);

        // Balikin ke login suruh masuk
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
