<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Store login timestamp in session
            $request->session()->put('login_time', now()->format('d/m/Y H:i'));

            // Role-based redirection
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.responders');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau kata laluan tidak tepat.',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Tampilkan halaman forgot password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim link reset password
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // Generate token
        $token = \Illuminate\Support\Str::random(60);

        // Store token in password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Send notification
        $user->notify(new ResetPasswordNotification($token));

        return back()->with(['status' => 'Link reset kata laluan telah dihantar ke e-mel anda.']);
    }

    // Tampilkan halaman reset password
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if token exists and is valid
        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('created_at', '>', now()->subHours(1)) // Token valid for 1 hour
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Token reset tidak sah atau telah tamat tempoh.']);
        }

        // Update user password
        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Kata laluan anda telah ditetapkan semula.');
    }
}
