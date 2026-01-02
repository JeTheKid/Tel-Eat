<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil order milik user yang login
        // Load relasi 'details.product' biar bisa nampilin nama menu
        $orders = Order::where('id_user', auth()->user()->id_user)
                    ->with('details.product')
                    ->latest() // Urutkan dari yang terbaru
                    ->get();

        return view('history', compact('orders'));
    }
}
