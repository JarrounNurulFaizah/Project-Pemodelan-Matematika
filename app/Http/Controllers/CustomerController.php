<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;

class CustomerController extends Controller
{
    /* ========== AUTHENTICATION ========== */

    public function showLoginForm()
    {
        return view('auth.customer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->route('customer.home');
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name_institution' => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:customers,email',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:255',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name_institution' => $request->name_institution,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'address'          => $request->address,
            'password'         => bcrypt($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.home')->with('success', 'Registration successful! Welcome.');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/')->with('success', 'You have been logged out.');
    }

    /* ========== CUSTOMER AREA ========== */

    public function home()
    {
        return view('customer.home');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    /* ========== TRANSACTIONS AREA ========== */

    public function transactions()
    {
        $customer = Auth::guard('customer')->user();
        $transactions = Transaction::where('customer_id', $customer->id)->latest()->get();

        return view('customer.transactions.index', compact('transactions'));
    }

    public function history()
    {
        $customer = Auth::guard('customer')->user();
        $transactions = Transaction::where('customer_id', $customer->id)->latest()->get();

        return view('customer.transactions.history', compact('transactions'));
    }
}
