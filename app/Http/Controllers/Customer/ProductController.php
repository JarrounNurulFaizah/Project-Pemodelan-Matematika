<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('customer.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('customer.products.show', compact('product'));
    }

    public function buyNow(Request $request, Product $product)
{
    $quantity = max((int) $request->input('quantity', 1), 1);

    $transaction = Transaction::create([
        'customer_id' => auth('customer')->id(),
        'transaction_number' => 'TRX' . time(),
        'total' => $product->price * $quantity,
        'ppn' => 0,
        'grand_total' => $product->price * $quantity,
    ]);

    $transaction->details()->create([
        'product_id' => $product->id,
        'item_name' => $product->name,
        'price' => $product->price,
        'quantity' => $quantity,
        'subtotal' => $product->price * $quantity,
    ]);

    return redirect()->route('customer.checkout.detail', ['id' => $transaction->id]);
}
}
