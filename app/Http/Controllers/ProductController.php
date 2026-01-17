<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Fungsi untuk mengambil semua data produk
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Fungsi untuk menambah produk baru (bisa dipakai nanti)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }
}
