<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $transactions = Transaction::where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('customer.transactions.index', compact('transactions'));
    }

    public function history()
    {
        $customer = Auth::guard('customer')->user();

        $transactions = Transaction::where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('customer.transactions.history', compact('transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_institution'   => 'required|string|max:255',
            'payment_method'     => 'required|string|max:255',
            'proof_of_payment'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $cartItems = session()->get('cart');

        if (!$cartItems || count($cartItems) === 0) {
            return redirect()->back()->with('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $proofOfPaymentPath = $request->file('proof_of_payment')->store('proofs', 'public');

        $transaction = new Transaction();
        $transaction->customer_id       = Auth::guard('customer')->id();
        $transaction->name_institution  = $validated['name_institution'];
        $transaction->payment_method    = $validated['payment_method'];
        $transaction->proof_of_payment  = $proofOfPaymentPath;
        $transaction->status            = 'pending';
        $transaction->save();

        foreach ($cartItems as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['id'],
                'item_name'      => $item['name'],
                'quantity'       => $item['quantity'],
                'price'          => $item['price'],
                'subtotal'       => $item['quantity'] * $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('customer.history')->with('success', 'Transaksi berhasil dikirim.');
    }

    public function generateInvoice(Transaction $transaction)
    {
        set_time_limit(180);

        $customer = Auth::guard('customer')->user();

        if ($transaction->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $transaction->load([
            'transactionDetails' => function ($query) {
                $query->select('id', 'transaction_id', 'product_id', 'item_name', 'quantity', 'price', 'subtotal');
            },
            'transactionDetails.product' => function ($query) {
                $query->select('id', 'name');
            },
            'customer',
        ]);

        $pdf = Pdf::loadView('customer.transactions.invoice', [
            'transaction' => $transaction,
            'customer'    => $customer,
        ]);

        return $pdf->stream('invoice-' . $transaction->id . '.pdf');
    }

    public function downloadInvoice($id)
    {
        $customer = Auth::guard('customer')->user();

        $transaction = Transaction::with([
            'transactionDetails' => function ($query) {
                $query->select('id', 'transaction_id', 'product_id', 'item_name', 'quantity', 'price', 'subtotal');
            },
            'transactionDetails.product' => function ($query) {
                $query->select('id', 'name');
            },
            'customer',
        ])->findOrFail($id);

        if ($transaction->customer_id !== $customer->id) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $title = 'Invoice';

        $pdf = Pdf::loadView('customer.transactions.invoice', [
            'transaction' => $transaction,
            'customer'    => $customer,
            'title'       => $title,
        ]);

        return $pdf->download('invoice_' . $transaction->transaction_number . '.pdf');
    }
}
