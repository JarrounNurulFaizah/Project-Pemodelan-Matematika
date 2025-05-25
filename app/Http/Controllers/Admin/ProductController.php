<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tampilkan daftar produk
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        return view('admin.products.create');
    }

    // Simpan data produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // Update data produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Jika upload gambar baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('picture')) {
            if ($product->picture) {
                Storage::disk('public')->delete($product->picture);
            }

            $validated['picture'] = $request->file('picture')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->picture) {
            Storage::disk('public')->delete($product->picture);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'The product was successfully removed.');
    }

    // Opsional: tampilkan detail produk (jika dibutuhkan)
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }
}
