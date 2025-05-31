<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class CartController extends Controller
{
    /**
     * Tambah produk ke keranjang biasa.
     */
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

        return redirect()->route('customer.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Fitur Beli Sekarang (Buy Now).
     * Buat transaksi langsung dari produk, lalu ke halaman detail transaksi.
     */
    public function buyNow(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        // Cek login customer
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login.form')->with('error', 'Silakan login terlebih dahulu sebelum membeli.');
        }

        // Bersihkan session cart dan buynow sebelumnya
        session()->forget('cart');
        session()->forget('buynow');

        $customer = Auth::guard('customer')->user();

        $total = $product->price * $quantity;
        $ppn = $total * 0.11;
        $grandTotal = $total + $ppn;

        $transaction = Transaction::create([
            'customer_id'        => $customer->id,
            'transaction_number' => 'TRX-' . strtoupper(uniqid()),
            'total'              => $total,
            'ppn'                => $ppn,
            'grand_total'        => $grandTotal,
            'status'             => 'pending',
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'item_name'      => $product->name,
            'quantity'       => $quantity,
            'price'          => $product->price,
            'subtotal'       => $total,
        ]);

        return redirect()->route('customer.checkout.detail', $transaction->id)
                         ->with('success', 'Pembelian berhasil. Silakan cek detail transaksi.');
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('customer.cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Alias method untuk menghapus produk.
     */
    public function remove($id)
    {
        return $this->delete($id);
    }

    /**
     * Bersihkan sesi "buynow".
     */
    public function clearBuyNow()
    {
        session()->forget('buynow');
        return redirect()->route('customer.cart')->with('success', 'Produk Buy Now berhasil dibatalkan.');
    }

    /**
     * Proses checkout dari keranjang dan buat transaksi baru.
     * Redirect ke halaman detail transaksi.
     */
    public function checkout(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login.form')->with('error', 'Silakan login terlebih dahulu sebelum checkout.');
        }

        $customer = Auth::guard('customer')->user();

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Tidak ada produk untuk checkout.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $ppn = $total * 0.11;
        $grandTotal = $total + $ppn;

        $transaction = Transaction::create([
            'customer_id'        => $customer->id,
            'transaction_number' => 'TRX-' . strtoupper(uniqid()),
            'total'              => $total,
            'ppn'                => $ppn,
            'grand_total'        => $grandTotal,
            'status'             => 'pending',
        ]);

        foreach ($cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['id'],
                'item_name'      => $item['name'],
                'quantity'       => $item['quantity'],
                'price'          => $item['price'],
                'subtotal'       => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');
        session()->forget('buynow');

        return redirect()->route('customer.checkout.detail', $transaction->id)
                         ->with('success', 'Checkout berhasil. Silakan cek detail transaksi.');
    }
}
