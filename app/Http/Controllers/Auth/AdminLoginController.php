<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Menampilkan form login admin
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->intended('/admin/home');
        }

        // Jika gagal login, kirim pesan error
        return back()->withInput($request->only('email'))->with('error', 'Email atau password salah.');
    }

    // Logout admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
