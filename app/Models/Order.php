<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Tambahkan ini agar data bisa diisi lewat Flutter
    protected $fillable = [
        'user_email',
        'product_name',
        'price',
        'status'
    ];
}
