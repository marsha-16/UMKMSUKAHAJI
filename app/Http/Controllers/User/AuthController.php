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

        if ($user->status !== 'approved') {
            Auth::logout();
            return redirect()->back()->withErrors([
                'email' => 'Akun anda belum disetujui admin.',
            ]);
        }

        return redirect()->intended('/dashboard');
    }

    return redirect()->back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}


    public function logout(Request $request)
{
    Auth::guard('web')->logout(); 
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); 
}
}