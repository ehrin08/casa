<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Services\CommissionService;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commissionService = new CommissionService();
        
        $transactions = Transaction::all();
        
        foreach ($transactions as $transaction) {
            $commission = $commissionService->createFromTransaction($transaction);
            
            if ($commission) {
                // Randomly mark some as paid or voided for demo purposes
                $randomStatus = rand(1, 10);
                
                if ($randomStatus <= 4) { // 40% paid
                    $commission->update([
                        'status' => 'paid',
                        'paid_at' => now()->subDays(rand(1, 30)),
                    ]);
                } elseif ($randomStatus === 10) { // 10% voided
                    $commissionService->voidCommission($commission, 'Customer disputed charge');
                }
            }
        }
    }
}
