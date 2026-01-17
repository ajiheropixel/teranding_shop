<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Pastikan ini sesuai dengan kolom di database Anda
    protected $fillable = ['name', 'description', 'price', 'stock', 'image_url'];
}
