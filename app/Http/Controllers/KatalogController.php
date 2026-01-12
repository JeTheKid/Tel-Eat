<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query (Filter cuma yang AKTIF)
        $query = Product::with('category')
                    ->where('status', 'aktif')
                    ->latest();

        // 2. Filter kategori (Logic lama kamu)
        if ($request->has('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // 3. Ambil data
        $products = $query->get();
        $categories = Category::all();

        return view('katalog', compact('products', 'categories'));
    }
}
