<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Services\TransactionService;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactionService = new TransactionService();
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            $transaction = $transactionService->createFromBooking($booking);
            
            if ($transaction) {
                // Determine payment status based on booking status
                $status = 'paid';
                if ($booking->status === 'cancelled') {
                    $status = 'cancelled';
                }

                $transaction->update([
                    'payment_status' => $status,
                    'payment_date' => $status === 'paid' ? $booking->appointment_date : null,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                ]);
            }
        }
    }
}
