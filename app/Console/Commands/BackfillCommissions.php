<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\CommissionService;
use Illuminate\Console\Command;

class BackfillCommissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commissions:backfill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely generate missing commission records for paid transactions.';

    /**
     * Execute the console command.
     */
    public function handle(CommissionService $commissionService)
    {
        $this->info('Starting commission backfill...');

        $transactions = Transaction::where('payment_status', 'paid')
                                   ->doesntHave('commission')
                                   ->get();

        if ($transactions->isEmpty()) {
            $this->info('No eligible paid transactions without a commission found.');
            return;
        }

        $count = 0;
        foreach ($transactions as $transaction) {
            $commission = $commissionService->createFromTransaction($transaction);
            if ($commission) {
                $count++;
            }
        }

        $this->info("Successfully generated $count commissions.");
    }
}
