<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Services\TransactionService;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionService = new TransactionService();
        $bookings = Booking::all();

        $statuses = ['paid', 'paid', 'paid', 'paid', 'unpaid', 'paid', 'paid', 'refunded', 'paid', 'cancelled'];
        
        foreach ($bookings as $index => $booking) {
            $transaction = $transactionService->createFromBooking($booking);
            
            if ($transaction && isset($statuses[$index])) {
                $status = $statuses[$index];
                
                // Override status for UI testing variety
                $transaction->update([
                    'payment_status' => $status,
                    'payment_date' => $status === 'paid' ? now()->subDays(rand(1, 5)) : null,
                ]);

                // Sync the booking status based on transaction variety to maintain consistency
                if ($status === 'cancelled') {
                    $booking->update(['status' => 'cancelled', 'payment_status' => 'cancelled']);
                } elseif ($status === 'unpaid') {
                    $booking->update(['payment_status' => 'unpaid']);
                }
            }
        }
    }
}
