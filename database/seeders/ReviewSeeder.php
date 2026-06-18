<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Review;
use App\Services\SentimentAnalysisService;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $sentimentService = new SentimentAnalysisService();
        $completedBookings = Booking::where('status', 'completed')->get();

        $comments = [
            5 => [
                "Amazing experience! The therapist was so professional and I feel completely relaxed.",
                "Best massage I've ever had. Highly recommend this spa to everyone.",
                "Excellent service, friendly staff, and great ambiance.",
                "Absolutely loved it. Will definitely come back again soon.",
                "Perfect pressure, very clean environment, and wonderful service."
            ],
            4 => [
                "Great massage, but the room was a bit cold.",
                "Very good experience overall. Therapist was skilled.",
                "Nice relaxing session. Good value for money.",
                "Enjoyed the service, though the waiting area was a bit crowded.",
                "Professional staff and good massage technique."
            ],
            3 => [
                "It was okay. Nothing spectacular but not bad either.",
                "Average experience. The massage was decent.",
                "Service was fine, but the appointment started 15 minutes late.",
                "Decent massage but the therapist talked too much during the session.",
                "Acceptable service for the price."
            ],
            2 => [
                "Disappointed. The pressure was too light and the therapist didn't listen to my requests.",
                "Not great. The room wasn't very clean and it smelled a bit weird.",
                "Poor experience. The massage was rushed and unprofessional.",
                "Felt uncomfortable. The therapist seemed inexperienced."
            ],
            1 => [
                "Terrible experience. Complete waste of money.",
                "Worst massage ever. The therapist was rude and the place was noisy.",
                "Absolutely awful. I left feeling more stressed than when I arrived.",
                "Never coming back. Horrible service and unprofessional behavior."
            ]
        ];

        $tagsList = ['professional', 'relaxing', 'clean', 'late', 'noisy', 'friendly', 'rude', 'skilled'];

        // Add reviews to about 70% of completed bookings
        foreach ($completedBookings->random($completedBookings->count() * 0.7) as $booking) {
            
            // Weight ratings: mostly 4 and 5
            $rand = rand(1, 100);
            if ($rand <= 50) $rating = 5;
            elseif ($rand <= 80) $rating = 4;
            elseif ($rand <= 90) $rating = 3;
            elseif ($rand <= 95) $rating = 2;
            else $rating = 1;

            $commentArray = $comments[$rating];
            $comment = $commentArray[array_rand($commentArray)];

            $tags = [];
            if ($rating >= 4) {
                $tags = collect($tagsList)->random(rand(1, 3))->intersect(['professional', 'relaxing', 'clean', 'friendly', 'skilled'])->toArray();
            } elseif ($rating <= 2) {
                $tags = collect($tagsList)->random(rand(1, 2))->intersect(['late', 'noisy', 'rude'])->toArray();
            }

            $analysis = $sentimentService->analyze($rating, $comment);

            Review::create([
                'booking_id' => $booking->id,
                'customer_id' => $booking->customer_id,
                'service_id' => $booking->service_id,
                'therapist_id' => $booking->therapist_id,
                'rating' => $rating,
                'comment' => $comment,
                'tags' => array_values($tags), // re-index
                'sentiment' => $analysis['sentiment'],
                'sentiment_score' => $analysis['sentiment_score'],
                'key_snippet' => $analysis['key_snippet'],
                'reviewed_at' => Carbon::parse($booking->appointment_date)->addDays(rand(1, 3))->addHours(rand(1, 23)),
                'status' => 'visible',
            ]);
        }
    }
}
