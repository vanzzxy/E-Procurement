<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('webutama.halamanlogin'); // sesuai view yang kamu pakai
    }

    // Proses login
    public function login(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credential)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('admin.beranda')->with('success', 'Login berhasil, selamat datang '.$user->username.'!');
            } else {
                return redirect()->route('vendor.beranda')->with('success', 'Login berhasil, selamat datang '.$user->username.'!');
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/halamanlogin'); // arahkan ke halaman login
    }
}
