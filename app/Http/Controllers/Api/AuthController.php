<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. REGISTER (Otomatis jadi 'user')
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => 'user', // Dikunci di sini agar tidak bisa pilih role sendiri
        ]);

        $token = $user->createToken('terandingtoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // 2. LOGIN (Mengirim data User + Role)
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Email atau Password Salah'], 401);
        }

        $token = $user->createToken('terandingtoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    // 3. LOGOUT
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return ['message' => 'Berhasil Keluar'];
    }
    // Fungsi khusus Admin untuk mengubah role User menjadi Staff atau Admin
    public function updateRole(Request $request, $id)
    {
        // 1. Cek apakah yang sedang login benar-benar Admin
        if (auth()->user()->role !== 'admin') {
            return response([
                'message' => 'Akses ditolak! Hanya Admin yang bisa mengubah role.'
            ], 403);
        }

        // 2. Validasi input role
        $request->validate([
            'role' => 'required|in:admin,staff,user'
        ]);

        // 3. Cari user yang mau diubah dan update
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response(['message' => 'User tidak ditemukan'], 404);
        }

        $user->update(['role' => $request->role]);

        return response([
            'message' => 'Berhasil! Kini ' . $user->name . ' berstatus sebagai ' . $request->role
        ], 200);
    }
}
