<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Commission;
use App\Models\CustomerRfmSnapshot;
use App\Models\PromotionRule;
use App\Models\CustomerPromotion;
use App\Models\Therapist;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $this->resolveDateRange($request);
        $data = $this->buildAnalyticsData($dateRange['start'], $dateRange['end']);
        $data['dateRangeText'] = $dateRange['text'];
        $data['filter'] = $dateRange['filter'];
        
        return view('manager.analytics.index', $data);
    }

    public function report(Request $request)
    {
        $dateRange = $this->resolveDateRange($request);
        $data = $this->buildAnalyticsData($dateRange['start'], $dateRange['end']);
        $data['dateRangeText'] = $dateRange['text'];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('manager.analytics.report', $data);
        return $pdf->download('analytics_report_' . Carbon::now()->format('Y_m_d') . '.pdf');
    }

    private function resolveDateRange(Request $request)
    {
        $filter = $request->input('filter', 'month');
        $start = null;
        $end = null;
        $text = '';

        if ($filter === 'today') {
            $start = Carbon::today();
            $end = Carbon::today()->endOfDay();
            $text = 'Today (' . $start->format('M d, Y') . ')';
        } elseif ($filter === 'week') {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            $text = 'This Week (' . $start->format('M d') . ' - ' . $end->format('M d, Y') . ')';
        } elseif ($filter === 'custom' && $request->has('date_from') && $request->has('date_to')) {
            $start = Carbon::parse($request->input('date_from'))->startOfDay();
            $end = Carbon::parse($request->input('date_to'))->endOfDay();
            $text = $start->format('M d, Y') . ' to ' . $end->format('M d, Y');
        } else {
            // Default to 'month'
            $filter = 'month';
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $text = 'This Month (' . $start->format('F Y') . ')';
        }

        return [
            'start' => $start,
            'end' => $end,
            'text' => $text,
            'filter' => $filter
        ];
    }

    private function buildAnalyticsData($startDate, $endDate)
    {
        // 1. Summary Cards
        $paidTransactions = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->get();

        $totalRevenue = $paidTransactions->sum('total_amount');
        $paidTxCount = $paidTransactions->count();
        $totalDiscounts = $paidTransactions->sum('discount_amount');
        
        $bookingsInDate = Booking::whereBetween('appointment_date', [$startDate, $endDate])->get();
        $totalBookings = $bookingsInDate->count();
        $completedBookings = $bookingsInDate->where('status', 'completed')->count();
        
        $atv = $paidTxCount > 0 ? $totalRevenue / $paidTxCount : 0;

        $unpaidCommissions = Commission::where('status', 'unpaid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $activePromotions = PromotionRule::where('status', 'active')->count();

        // 2. Charts Data
        // Revenue by Day
        $revenueByDay = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('DATE(payment_date) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Fill in missing dates for the chart
        $chartLabels = [];
        $chartRevenue = [];
        $chartDiscounts = [];
        $discountsByDayRaw = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('DATE(payment_date) as date, SUM(discount_amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $chartLabels[] = $currentDate->format('M d');
            $chartRevenue[] = $revenueByDay[$dateStr] ?? 0;
            $chartDiscounts[] = $discountsByDayRaw[$dateStr] ?? 0;
            $currentDate->addDay();
        }

        // Transaction Status Breakdown
        $txStatusBreakdown = Transaction::whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('payment_status, count(*) as count')
            ->groupBy('payment_status')
            ->get()
            ->pluck('count', 'payment_status')
            ->toArray();

        // Booking Status Breakdown
        $bookingStatusBreakdown = Booking::whereBetween('appointment_date', [$startDate, $endDate])
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Top Services by Revenue and Count
        $topServices = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->join('services', 'transactions.service_id', '=', 'services.id')
            ->selectRaw('services.name, SUM(transactions.total_amount) as revenue, COUNT(transactions.id) as count')
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $topServicesLabels = $topServices->pluck('name')->toArray();
        $topServicesRevenue = $topServices->pluck('revenue')->toArray();
        $topServicesCount = $topServices->pluck('count')->toArray();

        // 3. RFM Analytics
        $rfmSnapshots = CustomerRfmSnapshot::all();
        $totalAnalyzed = $rfmSnapshots->count();
        $rfmSegments = $rfmSnapshots->groupBy('segment')->map->count();
        $championsCount = $rfmSegments['champions'] ?? 0;
        $atRiskCount = $rfmSegments['at_risk'] ?? 0;
        $dormantCount = $rfmSegments['dormant'] ?? 0;

        $rfmSegmentDistribution = [
            'Champions' => $championsCount,
            'Loyal Customers' => $rfmSegments['loyal_customers'] ?? 0,
            'At Risk' => $atRiskCount,
            'New Customers' => $rfmSegments['new_customers'] ?? 0,
            'Dormant' => $dormantCount,
        ];

        $topSegmentsTable = CustomerRfmSnapshot::selectRaw('
                segment, 
                COUNT(*) as count, 
                AVG(monetary_total) as avg_monetary, 
                AVG(frequency_count) as avg_freq, 
                AVG(recency_days) as avg_recency
            ')
            ->groupBy('segment')
            ->orderByDesc('count')
            ->get();

        // 4. Promotion Analytics
        $generatedPromotionsCount = CustomerPromotion::count();
        $usedPromotionsCount = CustomerPromotion::where('status', 'used')->count();
        $availablePromotionsCount = CustomerPromotion::where('status', 'available')->count();
        $expiredPromotionsCount = CustomerPromotion::where('status', 'expired')->count();
        $promoUsageRate = $generatedPromotionsCount > 0 ? ($usedPromotionsCount / $generatedPromotionsCount) * 100 : 0;

        // 5. Commission Analytics
        $totalPaidCommissions = Commission::where('status', 'paid')->whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        $totalVoidedCommissions = Commission::where('status', 'void')->whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        
        $commissionByTherapist = Commission::with(['therapist.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('therapist_id, 
                         SUM(CASE WHEN status = "unpaid" THEN amount ELSE 0 END) as unpaid_total,
                         SUM(CASE WHEN status = "paid" THEN amount ELSE 0 END) as paid_total,
                         COUNT(*) as total_records')
            ->groupBy('therapist_id')
            ->get();

        return [
            // Summary
            'totalRevenue' => $totalRevenue,
            'paidTxCount' => $paidTxCount,
            'totalBookings' => $totalBookings,
            'completedBookings' => $completedBookings,
            'atv' => $atv,
            'totalDiscounts' => $totalDiscounts,
            'unpaidCommissions' => $unpaidCommissions,
            'activePromotions' => $activePromotions,
            
            // Charts
            'chartLabels' => $chartLabels,
            'chartRevenue' => $chartRevenue,
            'chartDiscounts' => $chartDiscounts,
            'txStatusBreakdown' => $txStatusBreakdown,
            'bookingStatusBreakdown' => $bookingStatusBreakdown,
            'topServicesLabels' => $topServicesLabels,
            'topServicesRevenue' => $topServicesRevenue,
            'topServicesCount' => $topServicesCount,
            'topServicesTable' => $topServices,

            // RFM
            'totalAnalyzed' => $totalAnalyzed,
            'championsCount' => $championsCount,
            'atRiskCount' => $atRiskCount,
            'dormantCount' => $dormantCount,
            'rfmSegmentDistribution' => $rfmSegmentDistribution,
            'topSegmentsTable' => $topSegmentsTable,

            // Promotions
            'generatedPromotionsCount' => $generatedPromotionsCount,
            'usedPromotionsCount' => $usedPromotionsCount,
            'availablePromotionsCount' => $availablePromotionsCount,
            'expiredPromotionsCount' => $expiredPromotionsCount,
            'promoUsageRate' => $promoUsageRate,

            // Commissions
            'totalPaidCommissions' => $totalPaidCommissions,
            'totalVoidedCommissions' => $totalVoidedCommissions,
            'commissionByTherapist' => $commissionByTherapist,
        ];
    }
}
