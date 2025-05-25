<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    // Tampilkan form login customer
    public function showLoginForm()
    {
        return view('auth.customer.login');
    }

    // Proses login customer
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Coba login
        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->intended('/customer/home');
        }

        // Gagal login, kembali ke form dengan pesan error
        return back()->withInput($request->only('email'))->with('error', 'Email atau password salah.');
    }

    // Logout customer
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
}
