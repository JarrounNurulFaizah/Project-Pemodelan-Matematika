<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.admin.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $admin = $this->create($request->all());

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.home');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
