<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Service;
use App\Models\Therapist;
use App\Services\CommissionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    protected $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    public function index(Request $request)
    {
        $query = Commission::with(['transaction', 'therapist.user', 'service', 'customer']);

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('commission_reference', 'like', "%{$searchTerm}%")
                  ->orWhereHas('transaction', function ($q2) use ($searchTerm) {
                      $q2->where('transaction_reference', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('therapist.user', function ($q3) use ($searchTerm) {
                      $q3->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('customer', function ($q4) use ($searchTerm) {
                      $q4->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('therapist_id')) {
            $query->where('therapist_id', $request->therapist_id);
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('earned_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('earned_at', '<=', $request->date_to);
        }

        $commissions = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $services = Service::all();
        $therapists = Therapist::with('user')->get();

        // Summary cards
        $totalUnpaid = Commission::where('status', 'unpaid')->sum('commission_amount');
        $totalPaid = Commission::where('status', 'paid')->sum('commission_amount');
        $totalVoided = Commission::where('status', 'voided')->sum('commission_amount');
        $thisMonthEarned = Commission::whereMonth('earned_at', now()->month)
                                     ->whereYear('earned_at', now()->year)
                                     ->where('status', '!=', 'voided')
                                     ->sum('commission_amount');

        return view('manager.commissions.index', compact(
            'commissions', 'services', 'therapists',
            'totalUnpaid', 'totalPaid', 'totalVoided', 'thisMonthEarned'
        ));
    }

    public function show(Commission $commission)
    {
        $commission->load(['transaction', 'booking', 'therapist.user', 'service', 'customer']);
        return view('manager.commissions.show', compact('commission'));
    }

    public function markPaid(Commission $commission)
    {
        if ($commission->status !== 'unpaid') {
            return back()->with('error', 'Only unpaid commissions can be marked as paid.');
        }

        $this->commissionService->markAsPaid($commission);

        return back()->with('success', 'Commission marked as paid successfully.');
    }

    public function void(Request $request, Commission $commission)
    {
        if ($commission->status === 'voided') {
            return back()->with('error', 'Commission is already voided.');
        }

        $reason = $request->input('reason', 'Manually voided by manager');
        $this->commissionService->voidCommission($commission, $reason);

        return back()->with('success', 'Commission voided successfully.');
    }

    public function report(Request $request)
    {
        $query = Commission::with(['transaction', 'therapist.user', 'service']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('therapist_id')) {
            $query->where('therapist_id', $request->therapist_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('earned_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('earned_at', '<=', $request->date_to);
        }

        $commissions = $query->orderBy('created_at', 'desc')->get();

        $totalGross = $commissions->sum('gross_amount');
        $totalCommission = $commissions->sum('commission_amount');
        
        $filters = $request->only(['status', 'therapist_id', 'date_from', 'date_to']);

        $pdf = Pdf::loadView('manager.commissions.report', compact('commissions', 'totalGross', 'totalCommission', 'filters'));
        
        return $pdf->stream('commission-report.pdf');
    }

    public function pdf(Commission $commission)
    {
        $commission->load(['transaction', 'booking', 'therapist.user', 'service', 'customer']);
        
        $pdf = Pdf::loadView('manager.commissions.pdf', compact('commission'));
        
        return $pdf->stream('commission-' . $commission->commission_reference . '.pdf');
    }
}
