<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Jika belum disetujui admin
            if ($user->status !== 'approved') {
                Auth::logout();
                return redirect()->back()->withErrors([
                    'email' => 'Akun anda belum disetujui admin.',
                ]);
            }

            // ✅ Kirim session success agar popup muncul
            return redirect()
                ->intended('/dashboard')
                ->with('success', 'Selamat Datang, ' . $user->name . '!');
        }

        // Gagal login
        return redirect()->back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); 
    }
}
