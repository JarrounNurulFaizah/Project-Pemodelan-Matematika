<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('customer')->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function verify($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'verified';
        $transaction->save();

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaction successfully verified.');
    }

    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Transaction rejected.');
    }

    public function deliveryOrder($id)
    {
        $transaction = Transaction::with([
            'customer',
            'paymentMethod',
            'transactionDetails.product'
        ])->findOrFail($id);

        $title = 'Delivery Order';

        return view('admin.transactions.delivery_order', compact('transaction', 'title'));
    }

    /**
     * Menampilkan PDF Delivery Order langsung di browser (tanpa download).
     */
    public function downloadDeliveryOrder($id)
    {
        $transaction = Transaction::with([
            'customer',
            'paymentMethod',
            'transactionDetails.product'
        ])->findOrFail($id);

        $title = 'Delivery Order';

        $pdf = Pdf::loadView('admin.transactions.delivery-order', compact('transaction', 'title'));

        return $pdf->stream('delivery-order_' . $transaction->transaction_number . '.pdf');
    }
}
