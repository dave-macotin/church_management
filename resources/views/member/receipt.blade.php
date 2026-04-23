<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Receipt - #{{ $donation->DonationID }}</title>
    <style>
        :root {
            --primary: #d85a30;
            --secondary: #2d3748;
            --text: #1a202c;
            --light: #f7fafc;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text);
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background: #fff;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            padding: 60px;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 60px;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 20px;
        }
        .logo-area h1 {
            margin: 0;
            color: var(--primary);
            font-size: 28px;
            letter-spacing: -0.02em;
        }
        .logo-area p {
            margin: 5px 0 0;
            color: #718096;
            font-size: 14px;
        }
        .receipt-title {
            text-align: right;
        }
        .receipt-title h2 {
            margin: 0;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--secondary);
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        .details-section h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #718096;
            margin-bottom: 15px;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .info-label { font-weight: 500; color: #4a5568; }
        .info-value { font-weight: 600; text-align: right; }

        .amount-card {
            background: var(--light);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 60px;
        }
        .amount-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 10px;
        }
        .amount-value {
            font-size: 48px;
            font-weight: 800;
            color: var(--primary);
        }

        .thank-you {
            text-align: center;
            font-style: italic;
            color: #718096;
            margin-bottom: 60px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            padding-top: 20px;
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 99px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(216, 90, 48, 0.3);
        }

        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
            .receipt-container { border: none; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print Receipt</button>

    <div class="receipt-container">
        <div class="header">
            <div class="logo-area">
                <h1>GRACE CHURCH</h1>
                <p>Faith. Community. Eternal Hope.</p>
            </div>
            <div class="receipt-title">
                <h2>Receipt</h2>
                <p style="margin:5px 0 0; color:#718096;">#{{ str_pad($donation->DonationID, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="details-grid">
            <div class="details-section">
                <h3>Donor Details</h3>
                <div class="info-row">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ Auth::user()->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ Auth::user()->email }}</span>
                </div>
            </div>
            <div class="details-section">
                <h3>Gift Details</h3>
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($donation->Date)->format('F d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fund Category</span>
                    <span class="info-value">{{ $donation->FundCategory }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method</span>
                    <span class="info-value">{{ $donation->PaymentMethod ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="amount-card">
            <div class="amount-label">Total Contribution Amount</div>
            <div class="amount-value">₱{{ number_format($donation->Amount, 2) }}</div>
        </div>

        <div class="thank-you">
            "Each of you should give what you have decided in your heart to give, not reluctantly or under compulsion, for God loves a cheerful giver." - 2 Corinthians 9:7
        </div>

        <div class="footer">
            This is an official electronic receipt for your donation. Thank you for your continued support of our ministry and mission.
            <br>
            Sacred Church Management System
        </div>
    </div>
</body>
</html>
