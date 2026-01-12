<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class LandingController extends Controller
{
    public function index()
    {
        // 1. Ambil 4 menu terbaru
        $products = Product::where('status', 'aktif')
                           ->latest()
                           ->take(4)
                           ->get();

        // 2. Hitung jumlah produk
        $totalProducts = Product::where('status', 'aktif')->count();

        // Hitung order sukses
        $totalOrders = Order::where('status', 'selesai')->count();

        // Kirim data ke view 'landing'
        return view('landing', compact('products', 'totalProducts', 'totalOrders'));
    }
}
