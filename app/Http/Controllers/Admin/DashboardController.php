<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Semua Pesanan Masuk
        $totalPesanan = Order::count();

        // 2. Pendapatan HARI INI (Cuma yang statusnya 'selesai')
        $pendapatanHariIni = Order::where('status', 'selesai')
            ->whereDate('updated_at', Carbon::today())
            ->sum('total_harga');

        // 3. Total Menu Tersedia
        $totalMenu = Product::count();

        // 4. Ambil 5 Pesanan Terakhir (Buat tabel)
        $recentOrders = Order::with(['user', 'details.product'])
            ->latest()
            ->take(5) // Cuma ambil 5 biji
            ->get();

        return view('admin.dashboard', compact(
            'totalPesanan',
            'pendapatanHariIni',
            'totalMenu',
            'recentOrders'
        ));
    }
}
