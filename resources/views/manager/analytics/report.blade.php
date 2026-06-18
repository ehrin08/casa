<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2c3e38;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2c3e38;
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            color: #666;
        }
        .section-title {
            background-color: #f4f4f4;
            padding: 8px;
            font-weight: bold;
            border-left: 4px solid #2c3e38;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .grid {
            width: 100%;
            margin-bottom: 20px;
        }
        .card {
            width: 24%;
            display: inline-block;
            vertical-align: top;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
            margin-right: 1%;
        }
        .card:last-child {
            margin-right: 0;
        }
        .card .title {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .card .value {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e38;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Casa Paraiso - Body and Wellness Spa</h1>
        <h2>Analytics Report</h2>
        <p><strong>Generated Date:</strong> {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}</p>
        <p><strong>Selected Date Range:</strong> {{ $dateRangeText }}</p>
    </div>

    <!-- SUMMARY METRICS -->
    <div class="section-title">Executive Summary</div>
    <div class="grid">
        <div class="card">
            <div class="title">Total Revenue</div>
            <div class="value">PHP {{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="card">
            <div class="title">Paid Transactions</div>
            <div class="value">{{ $paidTxCount }}</div>
        </div>
        <div class="card">
            <div class="title">Total Bookings</div>
            <div class="value">{{ $totalBookings }}</div>
        </div>
        <div class="card">
            <div class="title">Avg. Value (ATV)</div>
            <div class="value">PHP {{ number_format($atv, 2) }}</div>
        </div>
    </div>

    <div class="grid" style="margin-top: 10px;">
        <div class="card">
            <div class="title">Completed Bookings</div>
            <div class="value">{{ $completedBookings }}</div>
        </div>
        <div class="card">
            <div class="title">Total Discounts</div>
            <div class="value">PHP {{ number_format($totalDiscounts, 2) }}</div>
        </div>
        <div class="card">
            <div class="title">Commissions Payable</div>
            <div class="value">PHP {{ number_format($unpaidCommissions, 2) }}</div>
        </div>
        <div class="card">
            <div class="title">Active Promos</div>
            <div class="value">{{ $activePromotions }}</div>
        </div>
    </div>

    <!-- SALES BY DAY (Simplified Table for PDF) -->
    <div class="section-title">Revenue by Day</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th class="text-right">Revenue (PHP)</th>
                <th class="text-right">Discounts (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($chartLabels); $i++)
                @if($chartRevenue[$i] > 0 || $chartDiscounts[$i] > 0)
                    <tr>
                        <td>{{ $chartLabels[$i] }}</td>
                        <td class="text-right">{{ number_format($chartRevenue[$i], 2) }}</td>
                        <td class="text-right">{{ number_format($chartDiscounts[$i], 2) }}</td>
                    </tr>
                @endif
            @endfor
            @if(count(array_filter($chartRevenue)) == 0 && count(array_filter($chartDiscounts)) == 0)
                <tr>
                    <td colspan="3" class="text-center">No revenue recorded in this date range.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- TOP SERVICES -->
    <div class="section-title">Top Services Performance</div>
    <table>
        <thead>
            <tr>
                <th>Service Name</th>
                <th class="text-center">Booking Count</th>
                <th class="text-right">Revenue Generated (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topServicesTable as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td class="text-center">{{ $service->count }}</td>
                    <td class="text-right">{{ number_format($service->revenue, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No service data available in this range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- BOOKING STATUS BREAKDOWN -->
    <div class="section-title">Booking Status Breakdown</div>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th class="text-center">Count</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookingStatusBreakdown as $status => $count)
                <tr>
                    <td style="text-transform: capitalize;">{{ $status }}</td>
                    <td class="text-center">{{ $count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No bookings found in this range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- RFM SUMMARY -->
    <div class="section-title">Customer RFM Segment Summary</div>
    <p>Total Customers Analyzed: <strong>{{ $totalAnalyzed }}</strong></p>
    <table>
        <thead>
            <tr>
                <th>Segment</th>
                <th class="text-center">Customer Count</th>
                <th class="text-right">Average Spent (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topSegmentsTable as $seg)
                <tr>
                    <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $seg->segment) }}</td>
                    <td class="text-center">{{ $seg->count }}</td>
                    <td class="text-right">{{ number_format($seg->avg_monetary, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No RFM data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PROMOTION SUMMARY -->
    <div class="section-title">Promotion Engine Summary</div>
    <ul>
        <li>Generated Codes: <strong>{{ $generatedPromotionsCount }}</strong></li>
        <li>Available Codes: <strong>{{ $availablePromotionsCount }}</strong></li>
        <li>Used Codes: <strong>{{ $usedPromotionsCount }}</strong> ({{ number_format($promoUsageRate, 1) }}% usage rate)</li>
        <li>Expired Codes: <strong>{{ $expiredPromotionsCount }}</strong></li>
    </ul>

    <!-- COMMISSION SUMMARY -->
    <div class="section-title">Therapist Commission Summary</div>
    <table>
        <thead>
            <tr>
                <th>Therapist</th>
                <th class="text-center">Services Rendered</th>
                <th class="text-right">Unpaid (PHP)</th>
                <th class="text-right">Paid (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commissionByTherapist as $comm)
                <tr>
                    <td>{{ $comm->therapist->user->name ?? 'Unknown' }}</td>
                    <td class="text-center">{{ $comm->total_records }}</td>
                    <td class="text-right">{{ number_format($comm->unpaid_total, 2) }}</td>
                    <td class="text-right">{{ number_format($comm->paid_total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No commission records in this date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SENTIMENT PLACEHOLDER -->
    <div class="section-title">Customer Sentiment Overview</div>
    <p style="color: #666; font-style: italic;">Note: Sentiment analytics and customer reviews will be enabled after the Customer Reviews module is implemented. Data shown is a placeholder.</p>
    <ul>
        <li>Positive Feedback: Pending module activation</li>
        <li>Neutral Feedback: Pending module activation</li>
        <li>Negative Feedback: Pending module activation</li>
    </ul>

    <div class="footer">
        Confidential Document &copy; {{ date('Y') }} Casa Paraiso System. Intended for management use only.
    </div>

</body>
</html>
