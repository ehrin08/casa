<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use App\Services\SentimentAnalysisService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['service', 'therapist'])
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.reviews.index', compact('reviews'));
    }

    public function create(Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return redirect()->route('customer.bookings.show', $booking)->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return redirect()->route('customer.reviews.index')->with('info', 'You have already reviewed this booking.');
        }

        return view('customer.reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking, SentimentAnalysisService $sentimentService)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return redirect()->route('customer.bookings.show', $booking)->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return redirect()->route('customer.reviews.index')->with('error', 'You have already reviewed this booking.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'tags' => 'nullable|array',
            'tags.*' => 'string'
        ]);

        $sentimentResult = $sentimentService->analyze($validated['rating'], $validated['comment']);

        Review::create([
            'booking_id' => $booking->id,
            'customer_id' => Auth::id(),
            'service_id' => $booking->service_id,
            'therapist_id' => $booking->therapist_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'tags' => $validated['tags'] ?? [],
            'sentiment' => $sentimentResult['sentiment'],
            'sentiment_score' => $sentimentResult['sentiment_score'],
            'key_snippet' => $sentimentResult['key_snippet'],
            'status' => 'visible',
            'reviewed_at' => now(),
        ]);

        return redirect()->route('customer.reviews.index')->with('success', 'Thank you! Your review has been submitted successfully.');
    }
}
