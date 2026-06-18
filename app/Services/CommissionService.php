<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\Transaction;

class CommissionService
{
    /**
     * The fixed commission rate for this sprint.
     */
    const COMMISSION_RATE = 22.00;

    /**
     * Create or Sync a commission record from a transaction.
     */
    public function syncFromTransaction(Transaction $transaction): ?Commission
    {
        $commission = $transaction->commission;

        if ($transaction->payment_status === 'paid') {
            if (!$commission) {
                return $this->createFromTransaction($transaction);
            }
            
            // If exists and was previously voided, we can restore it to unpaid.
            if ($commission->status === 'voided') {
                $commission->update([
                    'status' => 'unpaid',
                    'voided_at' => null,
                ]);
            }
            
            return $commission;
        }

        if (in_array($transaction->payment_status, ['refunded', 'cancelled'])) {
            if ($commission && $commission->status !== 'voided') {
                return $this->voidCommission($commission, 'Transaction was ' . $transaction->payment_status);
            }
        }

        return $commission;
    }

    /**
     * Generates a new commission for a paid transaction.
     */
    public function createFromTransaction(Transaction $transaction): ?Commission
    {
        if ($transaction->payment_status !== 'paid') {
            return null; // Do not create for unpaid
        }

        if ($transaction->commission()->exists()) {
            return $transaction->commission;
        }

        $grossAmount = $transaction->total_amount; // Always use total amount
        $commissionAmount = $this->calculateCommissionAmount($grossAmount);

        return Commission::create([
            'commission_reference' => $this->generateReference(),
            'transaction_id' => $transaction->id,
            'booking_id' => $transaction->booking_id,
            'therapist_id' => $transaction->therapist_id,
            'service_id' => $transaction->service_id,
            'customer_id' => $transaction->customer_id,
            'gross_amount' => $grossAmount,
            'commission_rate' => self::COMMISSION_RATE,
            'commission_amount' => $commissionAmount,
            'status' => 'unpaid',
            'earned_at' => $transaction->payment_date ?? now(),
        ]);
    }

    public function markAsPaid(Commission $commission): Commission
    {
        $commission->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return $commission;
    }

    public function voidCommission(Commission $commission, ?string $reason = null): Commission
    {
        $commission->update([
            'status' => 'voided',
            'voided_at' => now(),
            'notes' => $reason ? $commission->notes . "\nVoid reason: " . $reason : $commission->notes,
        ]);

        return $commission;
    }

    public function calculateCommissionAmount(float $grossAmount, float $rate = self::COMMISSION_RATE): float
    {
        return round($grossAmount * ($rate / 100), 2);
    }

    public function generateReference(): string
    {
        $prefix = 'COM';
        $dateStr = now()->format('Ymd');
        $randomStr = strtoupper(substr(uniqid(), -4));

        $reference = "{$prefix}-{$dateStr}-{$randomStr}";

        while (Commission::where('commission_reference', $reference)->exists()) {
            $randomStr = strtoupper(substr(uniqid(), -4));
            $reference = "{$prefix}-{$dateStr}-{$randomStr}";
        }

        return $reference;
    }
}
