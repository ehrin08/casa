<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\PromotionRule;
use App\Models\CustomerPromotion;
use App\Models\CustomerRfmSnapshot;
use App\Models\Service;
use App\Models\User;
use App\Services\PromotionEngineService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $activeRulesCount = PromotionRule::where('status', 'active')->count();
        $generatedCount = CustomerPromotion::count();
        $usedCount = CustomerPromotion::where('status', 'used')->count();
        $rfmAnalyzedCount = CustomerRfmSnapshot::count();

        $recentPromotions = CustomerPromotion::with(['customer', 'rule'])
            ->latest()
            ->take(5)
            ->get();

        $segmentDistribution = CustomerRfmSnapshot::selectRaw('segment, count(*) as total')
            ->groupBy('segment')
            ->get();

        return view('manager.promotions.index', compact(
            'activeRulesCount',
            'generatedCount',
            'usedCount',
            'rfmAnalyzedCount',
            'recentPromotions',
            'segmentDistribution'
        ));
    }

    public function rules()
    {
        $rules = PromotionRule::with('applicableService')->paginate(10);
        return view('manager.promotions.rules.index', compact('rules'));
    }

    public function createRule()
    {
        $services = Service::all();
        return view('manager.promotions.rules.create', compact('services'));
    }

    public function storeRule(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'segment' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed,free_service',
            'discount_value' => 'required|numeric|min:0',
            'minimum_total_spent' => 'nullable|numeric|min:0',
            'minimum_visit_count' => 'nullable|integer|min:0',
            'maximum_days_since_last_visit' => 'nullable|integer|min:0',
            'minimum_days_since_last_visit' => 'nullable|integer|min:0',
            'applicable_service_id' => 'nullable|exists:services,id',
            'is_off_peak_only' => 'boolean',
            'off_peak_start_time' => 'nullable',
            'off_peak_end_time' => 'nullable',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'per_customer_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['is_off_peak_only'] = $request->has('is_off_peak_only');

        PromotionRule::create($validated);

        return redirect()->route('manager.promotions.rules')->with('success', 'Promotion rule created successfully.');
    }

    public function editRule(PromotionRule $promotionRule)
    {
        $services = Service::all();
        return view('manager.promotions.rules.edit', compact('promotionRule', 'services'));
    }

    public function updateRule(Request $request, PromotionRule $promotionRule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'segment' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed,free_service',
            'discount_value' => 'required|numeric|min:0',
            'minimum_total_spent' => 'nullable|numeric|min:0',
            'minimum_visit_count' => 'nullable|integer|min:0',
            'maximum_days_since_last_visit' => 'nullable|integer|min:0',
            'minimum_days_since_last_visit' => 'nullable|integer|min:0',
            'applicable_service_id' => 'nullable|exists:services,id',
            'is_off_peak_only' => 'boolean',
            'off_peak_start_time' => 'nullable',
            'off_peak_end_time' => 'nullable',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'per_customer_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['is_off_peak_only'] = $request->has('is_off_peak_only');

        $promotionRule->update($validated);

        return redirect()->route('manager.promotions.rules')->with('success', 'Promotion rule updated successfully.');
    }

    public function destroyRule(PromotionRule $promotionRule)
    {
        $promotionRule->delete();
        return redirect()->route('manager.promotions.rules')->with('success', 'Promotion rule deleted.');
    }

    public function generate(PromotionEngineService $engine)
    {
        $count = $engine->generateForAllCustomers();
        return redirect()->route('manager.promotions.index')->with('success', "Generated $count new promotions successfully after evaluating RFM.");
    }

    public function customerPromotions(Request $request)
    {
        $query = CustomerPromotion::with(['customer', 'rule']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%$search%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                  });
        }

        $promotions = $query->latest()->paginate(15);
        return view('manager.promotions.customer-promotions', compact('promotions'));
    }

    public function simulator()
    {
        $customers = User::where('role', 'customer')->get();
        $services = Service::all();
        $rules = PromotionRule::where('status', 'active')->get();
        return view('manager.promotions.simulator', compact('customers', 'services', 'rules'));
    }

    public function runSimulation(Request $request, PromotionEngineService $engine)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
        ]);

        $customer = User::findOrFail($request->customer_id);
        $snapshot = $customer->rfmSnapshot;

        if (!$snapshot) {
            return back()->with('error', 'Customer does not have an RFM snapshot yet. Please run Generation first.');
        }

        $rules = PromotionRule::where('status', 'active')->get();
        $results = [];

        foreach ($rules as $rule) {
            $eligible = $engine->isRuleEligibleForCustomer($rule, $customer, $snapshot);
            $results[] = [
                'rule' => $rule,
                'eligible' => $eligible,
                'reason' => $eligible ? 'Meets all criteria' : 'Failed one or more segment/limit checks',
            ];
        }

        return redirect()->route('manager.promotions.simulator')->with([
            'simulation_results' => $results,
            'simulated_customer' => $customer,
            'snapshot' => $snapshot
        ]);
    }
}
