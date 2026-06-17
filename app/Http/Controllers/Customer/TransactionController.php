<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('service')
            ->where('customer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->customer_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['booking', 'service', 'therapist.user']);
        return view('customer.transactions.show', compact('transaction'));
    }

    public function receipt(Transaction $transaction)
    {
        if ($transaction->customer_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['booking', 'customer', 'service', 'therapist.user']);
        
        $pdf = Pdf::loadView('manager.transactions.receipt', compact('transaction'));
        
        return $pdf->stream('receipt-' . $transaction->transaction_reference . '.pdf');
    }
}
