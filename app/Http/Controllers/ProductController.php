<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            // Tambahkan domain URL ke path gambar
            $product->image = asset('storage/' . $product->image);
            return $product;
        });

        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $path,
        ]);

        // Ubah response image agar Flutter langsung dapat URL lengkap
        $product->image = asset('storage/' . $product->image);

        return response()->json($product, 201);
    }
}
