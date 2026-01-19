<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Simpan data pesanan ke tabel orders
        $order = \App\Models\Order::create([
            'product_names' => $request->product_names,
            'total_price'   => $request->total_price,
        ]);

        // 2. Logika Potong Stok (Sederhana)
        // Kita pecah string "Sepatu, Kopi" menjadi array ["Sepatu", "Kopi"]
        $items = explode(", ", $request->product_names);

        foreach ($items as $name) {
            // Cari produk berdasarkan nama, lalu kurangi stoknya 1
            \App\Models\Product::where('name', $name)->decrement('stock', 1);
        }

        return response()->json(['message' => 'Berhasil dan Stok diperbarui'], 200);
    }
}
