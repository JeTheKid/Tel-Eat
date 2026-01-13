<?php

namespace App\Http\Controllers;

use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class CartController extends Controller
{
    // 1. Tampilkan Halaman Keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // 2. Tambah Barang ke Keranjang (DENGAN CEK STOK)
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // --- VALIDASI STOK 1: Cek apakah stok habis total? ---
        if ($product->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sudah habis terjual!');
        }

        // Kalau produk udah ada di keranjang, cek dulu sebelum nambah
        if (isset($cart[$id])) {
            // --- VALIDASI STOK 2: Cek apakah (jumlah skrg + 1) melebihi stok database? ---
            if (($cart[$id]['quantity'] + 1) > $product->stok) {
                return redirect()->back()->with('error', 'Stok tidak cukup! Sisa stok hanya: ' . $product->stok);
            }
            $cart[$id]['quantity']++;
        } else {
            // Kalau belum ada, masukin baru
            $cart[$id] = [
                "name" => $product->nama_produk,
                "quantity" => 1,
                "price" => $product->harga,
                "image" => $product->gambar,
                "id_produk" => $product->id_produk // ID penting buat validasi nanti
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu masuk keranjang!');
    }

    // 3. Update Barang via Input Manual (DENGAN CEK STOK)
    public function update(Request $request)
    {
        // PERBAIKAN: Gunakan isset() agar angka 0 tidak dianggap false
        if($request->id && isset($request->quantity)){
            $cart = session()->get('cart');

            // Ambil data produk asli buat cek stok
            $product = Product::findOrFail($request->id);

            // LOGIC 1: Kalau input 0 atau kurang, HAPUS item
            if ($request->quantity <= 0) {
                unset($cart[$request->id]);
                session()->flash('success', 'Menu dihapus dari keranjang.');
            }
            // LOGIC 2: Cek apakah input melebihi stok?
            else if ($request->quantity > $product->stok) {
                $cart[$request->id]["quantity"] = $product->stok;
                session()->flash('error', 'Maaf, stok hanya tersedia ' . $product->stok . '. Jumlah disesuaikan otomatis.');
            }
            // LOGIC 3: Update normal
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

        $banks = ShopSetting::all();
        return view('checkout', compact('cart', 'banks'));
    }

    // 6. PROSES CHECKOUT (POTONG STOK DISINI)
    public function processCheckout(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
        ]);

        $cart = session()->get('cart');

        // Cek ulang stok sebelum simpan (Jaga-jaga kalau stok dibeli orang lain pas lagi checkout)
        foreach ($cart as $id_produk => $details) {
            $productCheck = Product::find($id_produk);
            if (!$productCheck || $productCheck->stok < $details['quantity']) {
                return redirect()->back()->with('error', 'Stok produk ' . $details['name'] . ' tidak mencukupi atau sudah habis barusan. Silakan update keranjang.');
            }
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['price'] * $item['quantity'];
        }

        // 1. Simpan Bukti Bayar
        // Ganti 'bukti_bayar' folder sesuai kebutuhan (tadi kita pake folder 'toko' atau 'bukti')
        // Disini saya pake folder 'bukti_bayar'
        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        // 2. Buat Order
        $order = Order::create([
            'id_user' => auth()->user()->id_user,
            'total_harga' => $totalHarga,
            'status' => 'menunggu_konfirmasi',
            'bukti_bayar' => $path,
            'tanggal_order' => now(),
        ]);

        // 3. Simpan Detail & POTONG STOK
        foreach ($cart as $id_produk => $details) {
            OrderDetail::create([
                'id_order' => $order->id_order,
                'id_produk' => $id_produk,
                'jumlah' => $details['quantity'],
                'harga_satuan' => $details['price'],
            ]);

            // --- PENTING: KURANGI STOK PRODUK DI DATABASE ---
            $productToUpdate = Product::find($id_produk);
            if ($productToUpdate) {
                $productToUpdate->stok = $productToUpdate->stok - $details['quantity'];
                $productToUpdate->save();
            }
        }

        session()->forget('cart');

        return redirect()->route('katalog')->with('success', 'Pesanan berhasil! Stok produk telah diperbarui.');
    }

    // 7. Change Quantity (+/- Button) (DENGAN CEK STOK)
    public function changeQuantity(Request $request)
    {
        if ($request->id && $request->action) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                $product = Product::findOrFail($request->id);

                // Cek aksi: Mau nambah atau kurang?
                if ($request->action == 'increase') {
                    // --- VALIDASI STOK 4: Cek sebelum nambah ---
                    if (($cart[$request->id]['quantity'] + 1) > $product->stok) {
                        return redirect()->back()->with('error', 'Maksimal stok tercapai! Sisa: ' . $product->stok);
                    }
                    $cart[$request->id]['quantity']++;
                } else if ($request->action == 'decrease') {
                    $cart[$request->id]['quantity']--;
                }

                // Kalau jumlah 0, hapus
                if ($cart[$request->id]['quantity'] <= 0) {
                    unset($cart[$request->id]);
                    $pesan = 'Menu dihapus dari keranjang.';
                } else {
                    $pesan = 'Jumlah pesanan diperbarui!';
                }

                session()->put('cart', $cart);
                return redirect()->back()->with('success', $pesan);
            }
        }
    }
}
