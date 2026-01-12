<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 1. TAMPILKAN DAFTAR MENU
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. SIMPAN DATA BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'nama_produk' => $validated['name'],
            'id_kategori' => $validated['category_id'],
            'harga' => $validated['price'],
            'stok' => $validated['stock'],
            'deskripsi' => $validated['description'],
            'gambar' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Cari produk berdasarkan ID
        $categories = Category::all(); // Butuh kategori juga buat dropdown
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            // Simpan gambar baru
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            // Kalau gak upload baru, pakai gambar lama
            $validated['image'] = $product->gambar;
        }

        $product->update([
            'nama_produk' => $validated['name'],
            'id_kategori' => $validated['category_id'],
            'harga' => $validated['price'],
            'stok' => $validated['stock'],
            'deskripsi' => $validated['description'],
            'gambar' => $validated['image'],
        ]);

        return redirect()->route('products.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 1. CEK RIWAYAT: Apakah menu pernah dipesan
        // hitung ID produk di tabel order_details
        $jumlahPesanan = DB::table('order_details')->where('id_produk', $id)->count();

        if ($jumlahPesanan > 0) {
            // --- SKENARIO A: SUDAH PERNAH DIPESAN ---
            // Tidak boleh hapus permanen, nanti laporan keuangan rusak.
            // Solusi: Ganti Status (Arsip)

            if ($product->status == 'aktif') {
                $product->update(['status' => 'nonaktif']);
                $pesan = 'Menu telah DIARSIPKAN';
            } else {
                $product->update(['status' => 'aktif']);
                $pesan = 'Menu berhasil diaktifkan kembali!';
            }

        } else {
            // --- SKENARIO B: BELUM PERNAH DIPESAN ---
            // MENU DIHAPUS.

            // Hapus gambarnya dulu dari folder public/storage
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }

            // Hapus datanya dari database
            $product->delete();

            $pesan = 'Menu berhasil DIHAPUS PERMANEN (karena belum ada riwayat transaksi).';
        }

        return redirect()->route('products.index')->with('success', $pesan);
    }
}
