<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Reviews & Sentiment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e38;
            padding-bottom: 10px;
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
        .summary-box {
            background-color: #f9f8f6;
            border: 1px solid #e8dbce;
            padding: 15px;
            margin-bottom: 20px;
            width: 100%;
        }
        .summary-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-box td {
            width: 25%;
            text-align: center;
        }
        .summary-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e38;
        }
        .summary-box .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        h2 {
            color: #2c3e38;
            font-size: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        .text-green { color: green; }
        .text-red { color: red; }
        .text-right { text-align: right; }
        .explanation {
            font-style: italic;
            color: #666;
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Casa Paraiso – Body and Wellness Spa</h1>
        <h2>Customer Reviews and Sentiment Report</h2>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <div class="summary-box">
        <table>
            <tr>
                <td>
                    <div class="value">{{ $totalReviews }}</div>
                    <div class="label">Total Reviews</div>
                </td>
                <td>
                    <div class="value">{{ number_format($averageRating, 1) }}</div>
                    <div class="label">Average Rating</div>
                </td>
                <td>
                    <div class="value text-green">{{ $positiveReviews }}</div>
                    <div class="label">Positive Sentiment</div>
                </td>
                <td>
                    <div class="value text-red">{{ $negativeReviews }}</div>
                    <div class="label">Negative Sentiment</div>
                </td>
            </tr>
        </table>
    </div>

    <h2>Service Sentiment Breakdown</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Total Reviews</th>
                <th>Average Rating</th>
                <th>Negative Reviews</th>
            </tr>
        </thead>
        <tbody>
            @forelse($serviceRatings as $service)
                <tr>
                    <td>{{ $service['name'] }}</td>
                    <td>{{ $service['count'] }}</td>
                    <td>{{ number_format($service['avg_rating'], 1) }}</td>
                    <td>{{ $service['negatives'] }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No service data available.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Therapist Sentiment Breakdown</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Therapist Name</th>
                <th>Total Reviews</th>
                <th>Average Rating</th>
                <th>Negative Reviews</th>
            </tr>
        </thead>
        <tbody>
            @forelse($therapistRatings as $therapist)
                <tr>
                    <td>{{ $therapist['name'] }}</td>
                    <td>{{ $therapist['count'] }}</td>
                    <td>{{ number_format($therapist['avg_rating'], 1) }}</td>
                    <td>{{ $therapist['negatives'] }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No therapist data available.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Recent Negative Reviews</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Rating</th>
                <th>Key Snippet</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentNegatives as $review)
                <tr>
                    <td>{{ $review->reviewed_at->format('M d, Y') }}</td>
                    <td>{{ $review->customer->name }}</td>
                    <td>{{ $review->service->name }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>"{{ $review->key_snippet }}"</td>
                </tr>
            @empty
                <tr><td colspan="5">No negative reviews found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="explanation">
        Sentiment is computed automatically using a rule-based hybrid rating and keyword scoring method.
    </div>

</body>
</html>
