<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // 1. Tampilkan Halaman Keranjang
    public function index()
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // 2. Tambah Barang ke Keranjang
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Kalau produk udah ada, tambah jumlahnya
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Kalau belum ada, masukin baru
            $cart[$id] = [
                "name" => $product->nama_produk,
                "quantity" => 1,
                "price" => $product->harga,
                "image" => $product->gambar
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu masuk keranjang!');
    }

    // 3. update barang
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');

            // Kalau jumlahnya jadi 0 atau kurang, HAPUS dari session
            if ($request->quantity <= 0) {
                unset($cart[$request->id]);
                session()->flash('success', 'Menu dihapus dari keranjang.');
            }
            // Kalau jumlahnya positif, UPDATE angkanya
            else {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->flash('success', 'Jumlah pesanan diperbarui!');
            }

            session()->put('cart', $cart);
        }
    }

    // 4. Hapus Barang
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Menu dihapus dari keranjang');
        }
    }

    // 5. Halaman Checkout
    public function checkoutPage()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('katalog')->with('error', 'Keranjangmu kosong!');
        }

        //ambil dari database toko
        $toko = \App\Models\ShopSetting::first();

        // Kirim variabel $toko ke view
        return view('checkout', compact('cart', 'toko'));
    }

    // 6. PROSES CHECKOUT (Simpan ke Database)
    public function processCheckout(Request $request)
    {
        // Validasi Upload Bukti Bayar
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048', // Wajib gambar, max 2MB
        ]);

        $cart = session()->get('cart');
        $totalHarga = 0;

        // Hitung Total Dulu
        foreach ($cart as $item) {
            $totalHarga += $item['price'] * $item['quantity'];
        }

        // 1. Simpan Bukti Bayar
        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        // 2. Buat Data di Tabel ORDERS
        $order = \App\Models\Order::create([
            'id_user' => auth()->user()->id_user, // Ambil ID user yg login
            'total_harga' => $totalHarga,
            'status' => 'menunggu_konfirmasi',
            'bukti_bayar' => $path,
            'tanggal_order' => now(),
        ]);

        // 3. Pindahkan Isi Keranjang ke Tabel ORDER_DETAILS
        foreach ($cart as $id_produk => $details) {
            \App\Models\OrderDetail::create([
                'id_order' => $order->id_order, // Pake ID dari order yg baru dibuat
                'id_produk' => $id_produk,
                'jumlah' => $details['quantity'],
                'harga_satuan' => $details['price'],
            ]);
        }

        // 4. Kosongkan Keranjang Session
        session()->forget('cart');

        // 5. Redirect ke Halaman Sukses
        return redirect()->route('katalog')->with('success', 'Pesanan berhasil dibuat! Tunggu konfirmasi admin.');
    }
}
