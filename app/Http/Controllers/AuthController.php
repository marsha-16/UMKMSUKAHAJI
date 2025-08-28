<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return back();
        }

        return view('pages.auth.login');
    }
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return back();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;

            if ($userStatus == 'submitted') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda masih menunggu persetujuan admin',
                ]);
            } else if($userStatus == 'rejected') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda telah ditolak oleh admin',
                ]);
            }

            return redirect()->intended('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan, periksa kembali email atau password.',
        ])->onlyInput('email');
    }

    // Tampilkan form register
    public function registerView()
    {
        return view('pages.auth.register'); 
    }

    // Proses submit register
    public function registerSubmit(Request $request)
    {
        if (Auth::check()) {
            return back();
        }

        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ], [
            'name.required' => 'Nama Lengkap Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password Harus Diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 2; // User biasa
        $user->status = 'submitted'; // default pending approval
        $user->saveOrFail();

        return redirect('/login')->with('success', 'Berhasil mendaftarkan akun, menunggu persetujuan admin');
    }

    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $this->_logout($request);

        return redirect('/');
    }

    // =================== ADMIN LOGIN ===================
    public function loginAdmin()
    {

        if (Auth::check()) {
            return back();
        }

        return view('pages.auth.loginAdmin'); 
    }

    public function authenticateAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }
}
