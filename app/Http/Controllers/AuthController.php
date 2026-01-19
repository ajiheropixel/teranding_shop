<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // FUNGSI REGISTER
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set default role saat daftar adalah user biasa
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil didaftarkan',
            'user' => $user
        ], 201);
    }

    // FUNGSI LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role, // Data role dikirim ke Flutter
                ]
            ], 200);
        }

        // Jika login gagal
        return response()->json(['message' => 'Email atau password salah'], 401);
    }
}
