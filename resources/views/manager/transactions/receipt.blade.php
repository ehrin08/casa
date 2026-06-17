<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - {{ $transaction->transaction_reference }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 14px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2c3e38;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e38;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }
        .receipt-info {
            width: 100%;
            margin-bottom: 30px;
        }
        .receipt-info td {
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #555;
            width: 150px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f9f8f6;
            color: #2c3e38;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .totals-table {
            width: 50%;
            float: right;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 10px;
        }
        .totals-label {
            text-align: right;
            font-weight: bold;
            color: #555;
        }
        .totals-value {
            text-align: right;
            width: 120px;
        }
        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e38;
            border-top: 2px solid #2c3e38;
        }
        .footer {
            clear: both;
            margin-top: 80px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-unpaid { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .status-refunded { background-color: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Casa Paraiso</div>
        <div class="subtitle">Body and Wellness Spa</div>
        <p style="margin: 5px 0 0; font-size: 12px; color: #555;">123 Relaxation Road, Wellness City, 4567</p>
    </div>

    <table class="receipt-info">
        <tr>
            <td width="50%">
                <table cellpadding="3">
                    <tr>
                        <td class="label">Receipt No:</td>
                        <td>{{ $transaction->transaction_reference }}</td>
                    </tr>
                    @if($transaction->booking)
                    <tr>
                        <td class="label">Booking Ref:</td>
                        <td>{{ $transaction->booking->booking_reference }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label">Date:</td>
                        <td>{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Payment Status:</td>
                        <td>
                            @php
                                $statusClass = 'status-' . strtolower($transaction->payment_status);
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($transaction->payment_status) }}</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table cellpadding="3">
                    <tr>
                        <td class="label">Customer:</td>
                        <td>{{ $transaction->customer ? $transaction->customer->name : ($transaction->booking ? $transaction->booking->customer_name : 'Walk-in Guest') }}</td>
                    </tr>
                    @if($transaction->customer)
                    <tr>
                        <td class="label">Email:</td>
                        <td>{{ $transaction->customer->email }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label">Payment Method:</td>
                        <td>{{ ucfirst($transaction->payment_method) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Therapist</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $transaction->service->name }}</strong><br>
                    <span style="font-size: 12px; color: #777;">{{ $transaction->service->duration_minutes }} minutes session</span>
                    @if($transaction->booking)
                        <br><span style="font-size: 12px; color: #777;">Scheduled: {{ $transaction->booking->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($transaction->booking->start_time)->format('g:i A') }}</span>
                    @endif
                </td>
                <td>{{ $transaction->therapist->user->name }}</td>
                <td style="text-align: right;">₱{{ number_format($transaction->service->price, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td class="totals-label">Subtotal</td>
            <td class="totals-value">₱{{ number_format($transaction->subtotal, 2) }}</td>
        </tr>
        @if($transaction->discount_amount > 0)
        <tr>
            <td class="totals-label">Discount</td>
            <td class="totals-value" style="color: #d32f2f;">- ₱{{ number_format($transaction->discount_amount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td class="totals-label grand-total">Total Amount</td>
            <td class="totals-value grand-total">₱{{ number_format($transaction->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td class="totals-label">Amount Paid</td>
            <td class="totals-value">₱{{ number_format($transaction->amount_paid, 2) }}</td>
        </tr>
        <tr>
            <td class="totals-label">Change</td>
            <td class="totals-value">₱{{ number_format($transaction->change_amount, 2) }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>Thank you for choosing Casa Paraiso!</p>
        <p>If you have any questions about this receipt, please contact us at info@casaparaiso.com.</p>
    </div>

</body>
</html>
