<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Therapist Commission Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #2c3e38; padding-bottom: 20px; margin-bottom: 30px; }
        .title { color: #2c3e38; font-size: 24px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .subtitle { color: #666; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; margin-top: 5px; }
        .meta { margin-bottom: 30px; }
        .meta p { margin: 5px 0; font-size: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        th { background-color: #f9f8f6; color: #2c3e38; font-weight: bold; text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .amount { text-align: right; font-weight: bold; }
        .total-row td { border-top: 2px solid #2c3e38; font-size: 14px; padding-top: 15px; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Casa Paraiso</h1>
        <p class="subtitle">Body and Wellness Spa</p>
        <h2 style="font-size: 18px; margin-top: 20px; color: #2c3e38;">Therapist Commission Report</h2>
    </div>

    <div class="meta">
        <p><strong>Generated On:</strong> {{ now()->format('F d, Y h:i A') }}</p>
        @if(isset($filters['date_from']) || isset($filters['date_to']))
            <p><strong>Date Range:</strong> {{ $filters['date_from'] ?? 'Beginning' }} to {{ $filters['date_to'] ?? 'Today' }}</p>
        @endif
        @if(!empty($filters['status']))
            <p><strong>Status Filter:</strong> {{ ucfirst($filters['status']) }}</p>
        @endif
        <p><strong>Total Records:</strong> {{ $commissions->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Date Earned</th>
                <th>Therapist</th>
                <th>Service</th>
                <th>Status</th>
                <th class="amount">Gross Amount</th>
                <th class="amount">Commission ({{ config('app.commission_rate', '22') }}%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commissions as $commission)
                <tr>
                    <td>{{ $commission->commission_reference }}</td>
                    <td>{{ $commission->earned_at ? $commission->earned_at->format('M d, Y') : '-' }}</td>
                    <td>{{ $commission->therapist->user->name }}</td>
                    <td>{{ $commission->service->name }}</td>
                    <td>{{ ucfirst($commission->status) }}</td>
                    <td class="amount">{{ number_format($commission->gross_amount, 2) }}</td>
                    <td class="amount" style="color: #2c3e38;">{{ number_format($commission->commission_amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px;">No commissions found.</td>
                </tr>
            @endforelse
            
            @if($commissions->count() > 0)
                <tr class="total-row">
                    <td colspan="5" style="text-align: right; font-weight: bold;">Grand Total:</td>
                    <td class="amount">{{ number_format($totalGross, 2) }}</td>
                    <td class="amount" style="color: #2c3e38;">{{ number_format($totalCommission, 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        This is an internally generated document for Casa Paraiso Body and Wellness Spa.
    </div>
</body>
</html>
