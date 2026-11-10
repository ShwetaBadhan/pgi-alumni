<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Provisional Receipt - {{ $payment->utr_number }}</title>
    <style>
        @page { size: A4; margin: 14mm; }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 32px 16px;
        }

        .toolbar { max-width: 800px; margin: 0 auto 16px; text-align: right; }
        .toolbar button {
            padding: 9px 18px; font-size: 14px; background: #000; color: #fff;
            border: 1px solid #000; cursor: pointer;
        }
        .toolbar button:hover { background: #fff; color: #000; }

        .receipt {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 32px;
        }

        /* Header */
        .header { text-align: center; padding-bottom: 18px; margin-bottom: 22px; border-bottom: 2px solid #000; }
        .header h1 { margin: 0 0 4px; font-size: 24px; letter-spacing: 2px; }
        .header p { margin: 0; font-size: 14px; }

        /* Details */
        .details { width: 100%; border-collapse: collapse; margin-bottom: 22px; }
        .details td { width: 50%; vertical-align: top; padding: 0 0 16px; }
        .details td:last-child { padding-left: 24px; }
        .tag { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #555; margin-bottom: 2px; }
        .details .block { margin-bottom: 12px; }
        .details .block:last-child { margin-bottom: 0; }
        .details strong { font-weight: 700; }

        /* Items */
        .items { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .items th, .items td { border: 1px solid #000; padding: 9px 10px; text-align: left; }
        .items th { background: #eee; font-size: 13px; }
        .items .num { text-align: right; white-space: nowrap; }
        .items .total td { font-weight: 700; font-size: 15px; }

        .words { margin-bottom: 8px; }
        .words .tag { margin-bottom: 4px; }

        .footer { margin-top: 56px; text-align: right; }
        .signature { display: inline-block; min-width: 200px; border-top: 1px solid #000; padding-top: 6px; text-align: center; }

        .note { margin-top: 28px; font-size: 12px; color: #555; text-align: center; }

        @media print {
            body { padding: 0; }
            .toolbar { display: none; }
            .receipt { border: 1px solid #000; }
        }
    </style>
</head>

<body>
    @php
        $amountWords = null;
        if (class_exists('NumberFormatter')) {
            $fmt = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
            $rupees = (int) floor($payment->amount);
            $paise = (int) round(($payment->amount - $rupees) * 100);
            $amountWords = ucfirst($fmt->format($rupees)) . ' rupees' . ($paise ? ' and ' . $fmt->format($paise) . ' paise' : '');
        }
    @endphp

    <div class="toolbar">
        <button onclick="window.print()">Print receipt</button>
    </div>

    <div class="receipt">
        <div class="header">
            <h1>PROVISIONAL RECEIPT</h1>
            <p>PGI CHANDIGARH ALUMNI ASSOCIATION (PCAAS)</p>
        </div>

        <table class="details">
            <tr>
                <td>
                    <div class="block">
                        <span class="tag">Issued by</span>
                        <strong>PGI CHANDIGARH ALUMNI ASSOCIATION (PCAAS)</strong><br>
                        Madhya Marg, Sector 12,<br>
                        Chandigarh, 160012<br>
                        PAN: AAHAP4593R
                    </div>
                    <div class="block">
                        <span class="tag">Received from</span>
                        <strong>{{ $alumni->profile->title ?? '' }} {{ $alumni->profile->firstname }}
                            {{ $alumni->profile->lastname }}</strong><br>
                        Email: {{ $alumni->email }}<br>
                        Contact No: {{ $alumni->profile->contact_number ?? 'N/A' }}
                    </div>
                </td>
                <td>
                    <div class="block">
                        <span class="tag">Receipt number</span>
                        <strong>PCAAS{{ $payment->id }}</strong>
                    </div>
                    <div class="block">
                        <span class="tag">Date of transaction</span>
                        {{ $payment->created_at->setTimezone('Asia/Kolkata')->format('d M Y') }}
                    </div>
                    <div class="block">
                        <span class="tag">Order #</span>
                        {{ $payment->id }}
                    </div>
                    <div class="block">
                        <span class="tag">Delegate ID</span>
                        {{ $membershipId }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Particulars</th>
                    <th>HSN/SAC</th>
                    <th class="num">Qty</th>
                    <th class="num">Rate</th>
                    <th class="num">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>
                        @if ($payment->type == 'donation')
                            Donation Contribution
                        @elseif($payment->type == 'accompanying')
                            Accompanying Person Charge
                        @else
                            Membership Fees
                        @endif
                    </td>
                    <td>998596</td>
                    <td class="num">1</td>
                    <td class="num">INR {{ number_format($payment->amount, 2) }}</td>
                    <td class="num">INR {{ number_format($payment->amount, 2) }}</td>
                </tr>
                <tr class="total">
                    <td colspan="5" class="num">Total</td>
                    <td class="num">INR {{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="words">
            <span class="tag">Amount chargeable (in words)</span>
            {{ $amountWords ? $amountWords . ' only' : ucfirst($payment->amount) . ' INR only' }}
        </div>

        <div class="footer">
            <img src="{{ url('images/sign.png') }}" class="w-100" alt="">
            <div class="signature">Authorised Signatory</div>
        </div>

        <div class="note">This is a provisional receipt.</div>
    </div>
</body>

</html>