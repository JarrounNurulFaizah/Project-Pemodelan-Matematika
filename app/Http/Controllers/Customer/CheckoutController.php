<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function detail($id)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === 'buynow') {
            $item = session('buynow');

            if (
                !$item ||
                !isset($item['id'], $item['quantity'])
            ) {
                return redirect()->route('customer.cart')->with('warning', 'Data Buy Now tidak valid.');
            }

            $product = Product::find($item['id']);

            if (!$product) {
                return redirect()->route('customer.cart')->with('warning', 'Produk tidak ditemukan.');
            }

            $itemName = $product->name;
            $itemPrice = $product->price;

            $transaction = (object)[
                'id'                => 'preview-buynow',
                'transaction_number'=> 'PREVIEW-BUYNOW',
                'total'             => $itemPrice * $item['quantity'],
                'ppn'               => $itemPrice * $item['quantity'] * 0.11,
                'grand_total'       => $itemPrice * $item['quantity'] * 1.11,
                'created_at'        => Carbon::now(),
                'details'           => collect([
                    (object)[
                        'product'   => (object)['name' => $itemName],
                        'item_name' => $itemName,
                        'quantity'  => $item['quantity'],
                        'price'     => $itemPrice,
                        'subtotal'  => $itemPrice * $item['quantity'],
                    ]
                ]),
            ];

            return view('customer.checkout.detail', compact('transaction', 'customer'));
        }

        $transaction = Transaction::with('details')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$transaction) {
            return redirect()->route('customer.cart')->with('warning', 'Transaksi tidak ditemukan.');
        }

        return view('customer.checkout.detail', compact('transaction', 'customer'));
    }

    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        $buyNowItem = session('buynow');

        // Validasi item buy now atau cart
        $cartItems = $buyNowItem ? collect([$buyNowItem]) : collect(session('cart', []));

        $cartItems = $cartItems->filter(function ($item) {
            return isset($item['id'], $item['name'], $item['price'], $item['quantity']);
        });

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')->with('warning', 'Keranjang kosong atau data produk tidak lengkap.');
        }

        $existing = Transaction::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existing) {
            $existing->details()->delete();
            $existing->delete();
        }

        $total = $cartItems->sum(fn($item) => $item['price'] * $item['quantity']);
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

        foreach ($cartItems as $item) {
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

        return redirect()
            ->route('customer.checkout.detail', $transaction->id)
            ->with('success', 'Checkout successful. Please proceed to the payment confirmation.');
    }

    public function confirm($id)
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction = Transaction::with('details')
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$transaction) {
            return redirect()->route('customer.cart')->with('warning', 'Transaksi tidak ditemukan.');
        }

        $paymentMethods = PaymentMethod::all();

        return view('customer.checkout.confirm', compact('customer', 'transaction', 'paymentMethods'));
    }

    public function submitConfirmation(Request $request)
    {
        $request->validate([
            'name_institution'   => 'required|string|max:255',
            'payment_method_id'  => 'required|exists:payment_methods,id',
            'payment_proof'      => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'transaction_id'     => 'required|exists:transactions,id',
        ]);

        $customer = Auth::guard('customer')->user();

        $transaction = Transaction::where('id', $request->transaction_id)
            ->where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan atau sudah dikonfirmasi.');
        }

        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $transaction->update([
            'name_institution'   => $request->name_institution,
            'payment_method_id'  => $request->payment_method_id,
            'proof_of_payment'   => $proofPath,
            'status'             => 'waiting_verification',
        ]);

        return redirect()
            ->route('customer.history')
            ->with('success', 'Konfirmasi pembayaran berhasil dikirim.');
    }
}
