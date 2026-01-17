<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Coba simpan
        $save = \App\Models\Order::create([
            'product_names' => $request->product_names,
            'total_price'   => $request->total_price,
        ]);

        if ($save) {
            return response()->json(['message' => 'Sukses'], 200);
        } else {
            return response()->json(['message' => 'Gagal Simpan'], 500);
        }
    }
}
