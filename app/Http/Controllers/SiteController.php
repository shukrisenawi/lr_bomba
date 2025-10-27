<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function index()
    {
        echo 12321;
        return view('test.index');
    }

    public function testForgotPassword(Request $request)
    {
        $email = $request->input('email', 'admin@bomba.com'); // Email default untuk test

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        // Generate token
        $token = Str::random(60);

        // Simpan token ke tabel password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Kirim notifikasi email
        $user->notify(new ResetPasswordNotification($token));

        return response()->json(['message' => 'Email reset password telah dikirim']);
    }
}
