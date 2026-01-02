<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 4 menu terbaru buat ditampilkan di halaman depan
        $products = Product::latest()->take(4)->get();

        //hitung data total
        $totalProducts = Product::count(); // Hitung semua produk
        $totalOrders = Order::where('status', 'selesai')->count(); // Hitung order sukses

        // Kirim data ke view 'landing'
        return view('landing', compact('products', 'totalProducts', 'totalOrders'));
    }
}
