<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Transaction;

class TransactionService
{
    /**
     * Create a transaction from a booking.
     *
     * @param Booking $booking
     * @return Transaction|null
     */
    public function createFromBooking(Booking $booking): ?Transaction
    {
        // Prevent duplicates
        if ($booking->transaction) {
            return $booking->transaction;
        }

        $subtotal = $booking->service_price;
        $discountAmount = $booking->discount_amount ?? 0;
        $totalAmount = $subtotal - $discountAmount;
        $amountPaid = $booking->amount_paid;
        
        $changeAmount = $amountPaid - $totalAmount;
        if ($changeAmount < 0) {
            $changeAmount = 0; // Not fully paid logic can be handled later
        }

        $paymentStatus = $booking->payment_status ?: 'paid';
        $paymentDate = $paymentStatus === 'paid' ? now() : null;

        $transaction = Transaction::create([
            'transaction_reference' => $this->generateReference(),
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'service_id' => $booking->service_id,
            'therapist_id' => $booking->therapist_id,
            'customer_promotion_id' => $booking->customer_promotion_id,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'amount_paid' => $amountPaid,
            'change_amount' => $changeAmount,
            'payment_method' => $booking->payment_method ?: 'cash',
            'payment_status' => $paymentStatus,
            'payment_date' => $paymentDate,
            'notes' => 'Auto-generated transaction from booking ' . $booking->booking_reference,
        ]);

        if ($transaction->payment_status === 'paid') {
            app(CommissionService::class)->createFromTransaction($transaction);
        }

        return $transaction;
    }

    /**
     * Generate a unique transaction reference.
     *
     * @return string
     */
    public function generateReference(): string
    {
        do {
            $reference = 'CPT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        } while (Transaction::where('transaction_reference', $reference)->exists());

        return $reference;
    }
}
