<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerRegisterController extends Controller
{
    /**
     * Menampilkan form registrasi customer.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.customer-register'); // Pastikan file view ini ada: resources/views/auth/customer-register.blade.php
    }

    /**
     * Menangani proses registrasi customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name_institution' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email', // <- ke tabel customers
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Membuat customer baru
        Customer::create([
            'name_institution' => $validated['name_institution'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect ke halaman login customer dengan pesan sukses
        return redirect()->route('customer.login')->with('success', 'Registration successful! Please login.');
    }
}
