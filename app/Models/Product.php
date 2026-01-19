<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // WAJIB ADA INI
    protected $fillable = ['name', 'price', 'stock', 'description', 'image']; // Tambahkan description & stock
}
