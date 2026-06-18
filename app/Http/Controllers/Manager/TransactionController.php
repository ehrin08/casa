<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Therapist;
use App\Models\Transaction;
use App\Services\TransactionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['booking', 'customer', 'service', 'therapist.user']);

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('transaction_reference', 'like', "%{$searchTerm}%")
                  ->orWhereHas('booking', function ($q2) use ($searchTerm) {
                      $q2->where('booking_reference', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('customer', function ($q3) use ($searchTerm) {
                      $q3->where('name', 'like', "%{$searchTerm}%")
                         ->orWhere('email', 'like', "%{$searchTerm}%")
                         ->orWhere('phone', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filters
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        if ($request->filled('therapist_id')) {
            $query->where('therapist_id', $request->therapist_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $services = Service::all();
        $therapists = Therapist::with('user')->get();

        return view('manager.transactions.index', compact('transactions', 'services', 'therapists'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['booking', 'customer', 'service', 'therapist.user']);
        return view('manager.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:paid,unpaid,refunded,cancelled'
        ]);

        $transaction->update(['payment_status' => $validated['payment_status']]);

        // Sync back to booking conditionally if appropriate
        if ($transaction->booking) {
            $transaction->booking->update(['payment_status' => $validated['payment_status']]);
        }

        // Sync to commission
        app(\App\Services\CommissionService::class)->syncFromTransaction($transaction);

        return redirect()->route('manager.transactions.show', $transaction)
            ->with('success', 'Transaction status updated successfully.');
    }

    public function createFromBooking(Booking $booking)
    {
        if ($booking->transaction) {
            return back()->with('error', 'A transaction already exists for this booking.');
        }

        $transaction = $this->transactionService->createFromBooking($booking);

        return redirect()->route('manager.transactions.show', $transaction)
            ->with('success', 'Transaction generated successfully from booking.');
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load(['booking', 'customer', 'service', 'therapist.user']);
        
        $pdf = Pdf::loadView('manager.transactions.receipt', compact('transaction'));
        
        return $pdf->stream('receipt-' . $transaction->transaction_reference . '.pdf');
    }
}
