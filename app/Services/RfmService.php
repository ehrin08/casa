<?php

namespace App\Services;

use App\Models\User;
use App\Models\CustomerRfmSnapshot;
use App\Models\Transaction;
use Carbon\Carbon;

class RfmService
{
    /**
     * Calculate and save RFM snapshot for a single customer.
     * Only considers 'paid' transactions.
     */
    public function calculateForCustomer(User $customer): CustomerRfmSnapshot
    {
        $transactions = Transaction::where('customer_id', $customer->id)
            ->where('payment_status', 'paid')
            ->get();

        $frequency = $transactions->count();
        $monetary = $transactions->sum('total_amount');
        
        $recencyDays = null;
        if ($frequency > 0) {
            $lastTransactionDate = $transactions->max('payment_date');
            if ($lastTransactionDate) {
                $recencyDays = Carbon::parse($lastTransactionDate)->diffInDays(now());
            } else {
                // Fallback to created_at if payment_date is missing for some reason
                $recencyDays = Carbon::parse($transactions->max('created_at'))->diffInDays(now());
            }
        }

        // Simple scoring (1 to 5)
        $rScore = $this->calculateRecencyScore($recencyDays, $frequency);
        $fScore = $this->calculateFrequencyScore($frequency);
        $mScore = $this->calculateMonetaryScore($monetary);

        $segment = $this->determineSegment($rScore, $fScore, $mScore, $frequency, $recencyDays);
        $rfmScore = "{$rScore}{$fScore}{$mScore}";

        $snapshot = CustomerRfmSnapshot::updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'recency_days' => $recencyDays,
                'frequency_count' => $frequency,
                'monetary_total' => $monetary,
                'recency_score' => $rScore,
                'frequency_score' => $fScore,
                'monetary_score' => $mScore,
                'rfm_score' => $rfmScore,
                'segment' => $segment,
                'calculated_at' => now(),
            ]
        );

        return $snapshot;
    }

    /**
     * Calculate for all customers who have the 'customer' role.
     */
    public function calculateAllCustomers(): int
    {
        $customers = User::where('role', 'customer')->get();
        $count = 0;
        foreach ($customers as $customer) {
            $this->calculateForCustomer($customer);
            $count++;
        }
        return $count;
    }

    /**
     * Determine segment based on RFM rules.
     */
    public function determineSegment($rScore, $fScore, $mScore, $frequency, $recencyDays): string
    {
        if ($frequency == 0) {
            return 'dormant';
        }

        // Champions: high frequency/monetary, recent
        if ($fScore >= 4 && $mScore >= 4 && $rScore >= 4) {
            return 'champions';
        }

        // Loyal Customers: good frequency
        if ($fScore >= 3 && $rScore >= 3) {
            return 'loyal_customers';
        }

        // At Risk: high frequency historically, but haven't visited recently
        if ($fScore >= 3 && $rScore <= 2) {
            return 'at_risk';
        }

        // New Customers: visited recently but only 1 or 2 times
        if ($rScore >= 4 && $frequency <= 2) {
            return 'new_customers';
        }

        // Dormant: Haven't visited in a long time
        if ($rScore <= 1) {
            return 'dormant';
        }

        // Default fallback if it doesn't strictly meet others
        return 'loyal_customers';
    }

    // --- Private Scorers --- //

    private function calculateRecencyScore($recencyDays, $frequency): int
    {
        if ($frequency == 0 || $recencyDays === null) return 1;

        if ($recencyDays <= 30) return 5;
        if ($recencyDays <= 60) return 4;
        if ($recencyDays <= 90) return 3;
        if ($recencyDays <= 180) return 2;
        return 1;
    }

    private function calculateFrequencyScore($frequency): int
    {
        if ($frequency >= 10) return 5;
        if ($frequency >= 5) return 4;
        if ($frequency >= 3) return 3;
        if ($frequency >= 1) return 2;
        return 1;
    }

    private function calculateMonetaryScore($monetary): int
    {
        if ($monetary >= 10000) return 5;
        if ($monetary >= 5000) return 4;
        if ($monetary >= 2500) return 3;
        if ($monetary > 0) return 2;
        return 1;
    }
}
