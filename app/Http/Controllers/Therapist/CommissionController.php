<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $therapist = auth()->user()->therapist;
        
        if (!$therapist) {
            abort(403, 'Therapist profile not found.');
        }

        $query = Commission::with(['transaction', 'service'])->where('therapist_id', $therapist->id);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('earned_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('earned_at', '<=', $request->date_to);
        }

        $commissions = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Summary cards
        $totalUnpaid = Commission::where('therapist_id', $therapist->id)->where('status', 'unpaid')->sum('commission_amount');
        $totalPaid = Commission::where('therapist_id', $therapist->id)->where('status', 'paid')->sum('commission_amount');
        $thisMonthEarned = Commission::where('therapist_id', $therapist->id)
                                     ->whereMonth('earned_at', now()->month)
                                     ->whereYear('earned_at', now()->year)
                                     ->where('status', '!=', 'voided')
                                     ->sum('commission_amount');
        $totalRecords = Commission::where('therapist_id', $therapist->id)->count();

        return view('therapist.commissions.index', compact(
            'commissions', 'totalUnpaid', 'totalPaid', 'thisMonthEarned', 'totalRecords'
        ));
    }

    public function show(Commission $commission)
    {
        $therapist = auth()->user()->therapist;
        
        if (!$therapist || $commission->therapist_id !== $therapist->id) {
            abort(403);
        }

        $commission->load(['transaction', 'booking', 'service']);
        return view('therapist.commissions.show', compact('commission'));
    }

    public function report(Request $request)
    {
        $therapist = auth()->user()->therapist;
        
        if (!$therapist) {
            abort(403);
        }

        $query = Commission::with(['transaction', 'service'])->where('therapist_id', $therapist->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
        
        $filters = $request->only(['status', 'date_from', 'date_to']);

        $pdf = Pdf::loadView('therapist.commissions.report', compact('commissions', 'totalGross', 'totalCommission', 'filters', 'therapist'));
        
        return $pdf->stream('my-commission-report.pdf');
    }
}
