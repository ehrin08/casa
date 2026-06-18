<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerPromotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = CustomerPromotion::with('rule')
            ->where('customer_id', auth()->id())
            ->orderByRaw("FIELD(status, 'available', 'used', 'expired', 'cancelled')")
            ->orderBy('expires_at', 'asc')
            ->paginate(12);

        $availableCount = CustomerPromotion::where('customer_id', auth()->id())
            ->where('status', 'available')
            ->count();

        return view('customer.promotions.index', compact('promotions', 'availableCount'));
    }
}
