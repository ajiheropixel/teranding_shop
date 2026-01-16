<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens; // <--- Pastikan ada ini
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // <--- Tambahkan HasApiTokens di sini

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // ... sisa kode lainnya
}
