<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Services\CommissionService;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommissionSeeder extends Seeder
{
    public function run(): void
    {
        $commissionService = new CommissionService();
        
        $transactions = Transaction::all();
        
        foreach ($transactions as $transaction) {
            $commission = $commissionService->createFromTransaction($transaction);
            
            if ($commission) {
                // Randomly mark some as paid or voided for demo purposes
                $randomStatus = rand(1, 10);
                
                $status = 'unpaid';
                $paidAt = null;

                if ($randomStatus <= 4) { // 40% paid
                    $status = 'paid';
                    $paidAt = Carbon::parse($transaction->payment_date)->addDays(rand(1, 3));
                } elseif ($randomStatus === 10) { // 10% voided
                    $status = 'void';
                }

                $commission->update([
                    'status' => $status,
                    'paid_at' => $paidAt,
                    'created_at' => $transaction->payment_date ?? $transaction->created_at,
                    'updated_at' => $transaction->payment_date ?? $transaction->created_at,
                ]);
                
                if ($status === 'void') {
                    $commissionService->voidCommission($commission, 'Customer disputed charge');
                }
            }
        }
    }
}
