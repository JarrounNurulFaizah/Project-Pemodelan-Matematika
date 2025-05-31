<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class PaymentController extends Controller
{
    /**
     * Tampilkan form konfirmasi pembayaran.
     */
    public function create(Transaction $transaction)
    {
        // Pastikan transaksi milik customer yang sedang login
        if ($transaction->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.payment.confirmation', compact('transaction'));
    }

    /**
     * Simpan bukti pembayaran ke database dan storage.
     */
    public function store(Request $request, Transaction $transaction)
    {
        // Pastikan transaksi milik customer yang sedang login
        if ($transaction->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'payment_method' => 'required|string|max:50',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120', // maksimal 5MB
        ]);

        // Upload file dan update transaksi
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            $transaction->update([
                'institution_name' => $request->institution_name,
                'payment_method' => $request->payment_method,
                'payment_proof' => $path,
                'status' => 'Pending Confirmation', // Sesuai alur sistem
            ]);
        }

        return redirect()->route('customer.transactions')->with('success', 'Payment proof submitted successfully.');
    }
}
