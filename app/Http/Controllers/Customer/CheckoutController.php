<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Show checkout detail page.
     */
    public function detail()
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login.form')->with('error', 'Please log in first.');
        }

        $cartItems = session('cart', []);

        // Debug: ensure cart is not empty
        if (empty($cartItems)) {
            return redirect()->route('customer.home')->with('warning', 'Your cart is currently empty.');
        }

        // Prepare and complete cart data
        $cartItems = collect($cartItems)->map(function ($item) {
            $product = Product::find($item['id']);
            return [
                'id'       => $item['id'],
                'name'     => $item['name'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'image'    => $product?->picture ?? null,
            ];
        });

        $total = $cartItems->sum(fn($item) => $item['price'] * $item['quantity']);
        $ppn = $total * 0.11;
        $grandTotal = $total + $ppn;

        // Check for existing pending transaction
        $transaction = Transaction::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            $transaction = Transaction::create([
                'customer_id'        => $customer->id,
                'transaction_number' => 'TRX-' . strtoupper(uniqid()),
                'total'              => $total,
                'ppn'                => $ppn,
                'grand_total'        => $grandTotal,
                'status'             => 'pending',
            ]);
        } else {
            $transaction->update([
                'total'       => $total,
                'ppn'         => $ppn,
                'grand_total' => $grandTotal,
            ]);
        }

        // Remove old transaction details and store new ones
        $transaction->details()->delete();

        foreach ($cartItems as $item) {
            try {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['id'],
                    'item_name'      => $item['name'],
                    'quantity'       => $item['quantity'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['price'] * $item['quantity'],
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to save transaction detail: " . $e->getMessage());
            }
        }

        return view('customer.checkout.detail', compact(
            'cartItems', 'total', 'ppn', 'grandTotal', 'customer', 'transaction'
        ));
    }

    /**
     * Show payment confirmation page.
     */
    public function confirm()
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login.form')->with('error', 'Please log in first.');
        }

        $transaction = Transaction::with('details.product')
            ->where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            return redirect()->route('customer.checkout.detail')->with('warning', 'Please complete the checkout first.');
        }

        $paymentMethods = PaymentMethod::whereIn('name', ['BNI', 'BCA'])->get();

        return view('customer.checkout.confirm', compact(
            'customer', 'transaction', 'paymentMethods'
        ));
    }

    /**
     * Handle payment confirmation submission.
     */
    public function submitConfirmation(Request $request)
    {
        $request->validate([
            'name_institution'   => 'required|string|max:255',
            'payment_method_id'  => 'required|exists:payment_methods,id',
            'payment_proof'      => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $customer = Auth::guard('customer')->user();

        $transaction = Transaction::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'No pending transaction available for confirmation.');
        }

        // Store payment proof
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update transaction
        $transaction->update([
            'name_institution'   => $request->name_institution,
            'payment_method_id'  => $request->payment_method_id,
            'proof_of_payment'   => $proofPath,
            'status'             => 'waiting_verification',
        ]);

        // Clear cart session
        session()->forget('cart');

        return redirect()->route('customer.history')->with('success', 'Payment confirmation submitted successfully.');
    }
}
