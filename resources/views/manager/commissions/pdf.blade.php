<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commission Record - {{ $commission->commission_reference }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #2c3e38; padding-bottom: 20px; margin-bottom: 30px; }
        .title { color: #2c3e38; font-size: 24px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .subtitle { color: #666; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; margin-top: 5px; }
        .meta { margin-bottom: 30px; border: 1px solid #eee; padding: 15px; border-radius: 5px; background-color: #f9f8f6; }
        .meta p { margin: 5px 0; font-size: 12px; color: #555; }
        .meta strong { color: #333; display: inline-block; width: 150px; }
        
        .box-container { margin-top: 30px; }
        .box { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; }
        .box h3 { margin-top: 0; color: #2c3e38; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 16px; }
        .box p { margin: 8px 0; font-size: 13px; }
        .box strong { display: inline-block; width: 140px; }

        .computation { margin-top: 30px; border: 2px solid #2c3e38; padding: 20px; background-color: #f0f4f2; }
        .computation h3 { margin-top: 0; color: #2c3e38; border-bottom: 1px solid #ccc; padding-bottom: 10px; text-align: center; font-size: 18px; }
        .comp-row { display: block; clear: both; overflow: hidden; margin-bottom: 10px; font-size: 14px; }
        .comp-label { float: left; width: 60%; font-weight: bold; color: #555; }
        .comp-value { float: right; width: 40%; text-align: right; }
        .comp-total { font-size: 18px; color: #2c3e38; font-weight: bold; border-top: 1px solid #2c3e38; padding-top: 10px; margin-top: 10px; }

        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Casa Paraiso</h1>
        <p class="subtitle">Body and Wellness Spa</p>
        <h2 style="font-size: 18px; margin-top: 20px; color: #2c3e38;">Commission Record</h2>
    </div>

    <div class="meta">
        <p><strong>Commission Reference:</strong> {{ $commission->commission_reference }}</p>
        <p><strong>Transaction Ref:</strong> {{ $commission->transaction->transaction_reference ?? 'N/A' }}</p>
        <p><strong>Booking Ref:</strong> {{ $commission->booking->booking_reference ?? 'N/A' }}</p>
        <p><strong>Generated On:</strong> {{ $commission->created_at->format('F d, Y h:i A') }}</p>
    </div>

    <div class="box-container">
        <div class="box">
            <h3>Therapist Details</h3>
            <p><strong>Name:</strong> {{ $commission->therapist->user->name }}</p>
            <p><strong>Email:</strong> {{ $commission->therapist->user->email }}</p>
            <p><strong>Specialization:</strong> {{ $commission->therapist->specialization }}</p>
        </div>

        <div class="box">
            <h3>Service Rendered</h3>
            <p><strong>Service:</strong> {{ $commission->service->name }}</p>
            <p><strong>Customer:</strong> {{ $commission->customer ? $commission->customer->name : 'Walk-in Guest' }}</p>
            <p><strong>Date Earned:</strong> {{ $commission->earned_at ? $commission->earned_at->format('F d, Y') : 'N/A' }}</p>
        </div>
    </div>

    <div class="computation">
        <h3>Commission Computation</h3>
        
        <div class="comp-row">
            <div class="comp-label">Gross Amount (Transaction Total)</div>
            <div class="comp-value">{{ number_format($commission->gross_amount, 2) }}</div>
        </div>
        
        <div class="comp-row">
            <div class="comp-label">Commission Rate</div>
            <div class="comp-value">{{ number_format($commission->commission_rate, 0) }}%</div>
        </div>

        <div class="comp-row comp-total">
            <div class="comp-label">Net Commission Earned</div>
            <div class="comp-value">PHP {{ number_format($commission->commission_amount, 2) }}</div>
        </div>

        <div style="margin-top: 20px; text-align: center; padding-top: 15px; border-top: 1px dashed #ccc;">
            <p style="margin:0; font-size: 12px; color: #666;">
                <strong>Status:</strong> {{ strtoupper($commission->status) }}
                @if($commission->status === 'paid')
                    (Settled on {{ $commission->paid_at->format('M d, Y') }})
                @elseif($commission->status === 'voided')
                    (Voided on {{ $commission->voided_at->format('M d, Y') }})
                @endif
            </p>
        </div>
    </div>

    <div class="footer">
        This document serves as an official internal commission record for Casa Paraiso Body and Wellness Spa.
    </div>
</body>
</html>
