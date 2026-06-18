<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['customer', 'service', 'therapist.user']);

        if ($request->filled('sentiment')) {
            $query->where('sentiment', $request->sentiment);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('service', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Summary cards
        $totalReviews = Review::count();
        $positiveReviews = Review::where('sentiment', 'positive')->count();
        $negativeReviews = Review::where('sentiment', 'negative')->count();
        $averageRating = Review::avg('rating') ?? 0;

        return view('manager.reviews.index', compact(
            'reviews', 'totalReviews', 'positiveReviews', 'negativeReviews', 'averageRating'
        ));
    }

    public function show(Review $review)
    {
        $review->load(['customer', 'service', 'therapist.user', 'booking']);
        return view('manager.reviews.show', compact('review'));
    }

    public function hide(Review $review)
    {
        $review->update(['status' => 'hidden']);
        return redirect()->back()->with('success', 'Review has been hidden from public view.');
    }

    public function showReview(Review $review)
    {
        $review->update(['status' => 'visible']);
        return redirect()->back()->with('success', 'Review is now visible.');
    }

    public function report(Request $request)
    {
        $query = Review::with(['customer', 'service', 'therapist.user']);
        
        // Optional filters for report
        if ($request->filled('sentiment')) {
            $query->where('sentiment', $request->sentiment);
        }

        $reviews = $query->orderBy('created_at', 'desc')->get();

        $totalReviews = $reviews->count();
        $positiveReviews = $reviews->where('sentiment', 'positive')->count();
        $negativeReviews = $reviews->where('sentiment', 'negative')->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

        // Service aggregation
        $serviceRatings = $reviews->groupBy('service_id')->map(function($serviceReviews) {
            return [
                'name' => $serviceReviews->first()->service->name ?? 'Unknown',
                'count' => $serviceReviews->count(),
                'avg_rating' => $serviceReviews->avg('rating'),
                'negatives' => $serviceReviews->where('sentiment', 'negative')->count()
            ];
        })->sortByDesc('count');

        // Therapist aggregation
        $therapistRatings = $reviews->groupBy('therapist_id')->map(function($therapistReviews) {
            return [
                'name' => $therapistReviews->first()->therapist->user->name ?? 'Unknown',
                'count' => $therapistReviews->count(),
                'avg_rating' => $therapistReviews->avg('rating'),
                'negatives' => $therapistReviews->where('sentiment', 'negative')->count()
            ];
        })->sortByDesc('count');

        $recentNegatives = $reviews->where('sentiment', 'negative')->take(10);

        $data = [
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'positiveReviews' => $positiveReviews,
            'negativeReviews' => $negativeReviews,
            'averageRating' => $averageRating,
            'serviceRatings' => $serviceRatings,
            'therapistRatings' => $therapistRatings,
            'recentNegatives' => $recentNegatives,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('manager.reviews.report', $data);
        return $pdf->download('sentiment_report_' . Carbon::now()->format('Y_m_d') . '.pdf');
    }
}
