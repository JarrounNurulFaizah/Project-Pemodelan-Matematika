<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer; 

class UserController extends Controller
{
    // Menampilkan daftar customer
    public function index()
    {
        $users = Customer::all(); // ambil semua customer dari tabel customers
        return view('admin.users.index', compact('users'));
    }

    // Menghapus customer
    public function destroy($id)
    {
        $user = Customer::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Customer berhasil dihapus.');
    }
}
