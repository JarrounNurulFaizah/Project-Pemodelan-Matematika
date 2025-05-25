<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk di halaman katalog customer.
     
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua produk dari database
        $products = Product::all();

        // Mengirim data produk ke view 'customer.products.index'
        return view('customer.products.index', compact('products'));
    }

    /**
     * Menampilkan halaman detail dari satu produk.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Mengirim data produk ke view 'customer.products.show'
        return view('customer.products.show', compact('product'));
    }
}
