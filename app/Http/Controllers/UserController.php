<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Cari user berdasarkan email yang dikirim dari Flutter/Postman
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->name = $request->name;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
                'user'    => $user
            ], 200);
        }

        // Jika user dengan email tersebut tidak ada di tabel users
        return response()->json([
            'success' => false,
            'message' => 'User dengan email ' . $request->email . ' tidak ditemukan di database'
        ], 404);
    }
}
