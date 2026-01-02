<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // 1. Tampilkan Semua Pesanan
    public function index()
    {
        // Ambil data order + user yg mesan + itemnya
        // Urutkan dari yg terbaru (latest)
        $orders = Order::with(['user', 'details.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // 2. Update Status (Terima / Tolak / Selesai)
    public function updateStatus(Request $request, $id_order)
    {
        $order = Order::findOrFail($id_order);

        // Validasi status yg boleh dipilih
        $request->validate([
            'status' => 'required|in:diproses,selesai,batal',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
