<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $quantity,
                'image'    => $product->picture,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('customer.cart')->with('success', 'Product successfully added to cart!');
    }

    public function buyNow(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        session()->put('buynow', [
            'product_id' => $product->id,
            'id'         => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'quantity'   => $quantity,
            'image'      => $product->picture,
        ]);

        return redirect()->route('customer.cart')->with('success', 'Product is ready for checkout!');
    }

    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('customer.cart')->with('success', 'Product successfully removed from cart.');
    }

    public function remove($id)
    {
        return $this->delete($id);
    }

    public function clearBuyNow()
    {
        session()->forget('buynow');

        return redirect()->route('customer.cart')->with('success', 'Buy Now product has been canceled.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Cart is empty!');
        }

        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')->with('error', 'Please login before checking out.');
        }

        $customer = Auth::guard('customer')->user();

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $ppn = $total * 0.11;
        $grandTotal = $total + $ppn;

        // Simpan transaksi utama
        $transaction = Transaction::create([
            'customer_id'        => $customer->id,
            'transaction_number' => 'TRX-' . strtoupper(uniqid()),
            'total'              => $total,
            'ppn'                => $ppn,
            'grand_total'        => $grandTotal,
            'status'             => 'pending',
        ]);

        // Pastikan transaksi berhasil dibuat sebelum melanjutkan
        if (!$transaction) {
            return redirect()->route('customer.cart')->with('error', 'Failed to create transaction.');
        }

        // Simpan detail setiap produk dalam transaksi
        foreach ($cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['id'],
                'quantity'       => $item['quantity'],
                'price'          => $item['price'],
                'subtotal'       => $item['price'] * $item['quantity'],
            ]);
        }

        // Hapus keranjang setelah checkout
        session()->forget('cart');

        return redirect()
            ->route('customer.checkout.confirm', $transaction->id)
            ->with('success', 'Checkout berhasil. Silakan lakukan pembayaran.');
    }
}
