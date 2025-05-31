<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class UserController extends Controller
{
    // Display a list of customers
    public function index()
    {
        $users = Customer::all(); // Get all customers from the customers table
        return view('admin.users.index', compact('users'));
    }

    // Display details of a specific customer
    public function show($id)
    {
        $user = Customer::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Delete a customer
    public function destroy($id)
    {
        $user = Customer::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Customer successfully deleted.');
    }
}
