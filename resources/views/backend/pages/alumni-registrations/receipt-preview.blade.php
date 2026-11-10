@extends('backend.layouts.master')

@section('content')
    <div class="dashboard-main-body">
        <!-- Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div>
                <h6 class="fw-semibold mb-0">Receipt Preview</h6>
                <p class="text-neutral-600 mt-4 mb-0">Payment Receipt for {{ $alumni->profile->firstname ?? 'Alumni' }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('alumni-registrations.show', $alumni->id) }}" class="btn btn-light">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
                <a href="{{ route('alumni-payments.receipt.download', $payment->id) }}" class="btn btn-primary"
                    target="_blank">
                    <i class="ri-download-line"></i> Download PDF
                </a>
            </div>
        </div>

        <!-- Receipt Preview -->
        <div class="card">
            <div class="card-body p-0">
                <div class="receipt-preview" style="padding: 40px; background: #f5f5f5;">
                    <div class="receipt"
                        style="max-width: 800px; margin: 0 auto; background: white; border: 1px solid #ddd; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div class="header"
                            style="text-align: center; padding-bottom: 20px; margin-bottom: 30px; border-bottom: 2px solid #000;">
                            <h1 style="margin: 0 0 5px; font-size: 28px; letter-spacing: 2px;">PROVISIONAL RECEIPT</h1>
                            <p style="margin: 0; font-size: 16px; font-weight: bold;">PGI CHANDIGARH ALUMNI ASSOCIATION
                                (PCAAS)</p>
                        </div>

                        <table style="width: 100%; margin-bottom: 30px; border-collapse: collapse;">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 0 20px 20px 0;">
                                    <div style="margin-bottom: 15px;">
                                        <span
                                            style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 3px;">Issued
                                            by</span>
                                        <strong>PGI CHANDIGARH ALUMNI ASSOCIATION (PCAAS)</strong><br>
                                        Madhya Marg, Sector 12,<br>
                                        Chandigarh, 160012<br>
                                        PAN: AAHAP4593R
                                    </div>
                                    <div>
                                        <span
                                            style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 3px;">Received
                                            from</span>
                                        <strong>{{ $alumni->profile->title ?? '' }} {{ $alumni->profile->firstname }}
                                            {{ $alumni->profile->lastname }}</strong><br>
                                        Email: {{ $alumni->email }}<br>
                                        Contact No: {{ $alumni->profile->contact_number ?? 'N/A' }}
                                    </div>
                                </td>
                                <td style="width: 50%; vertical-align: top; padding-left: 20px;">
                                    <div style="margin-bottom: 15px;">
                                        <span
                                            style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 3px;">Receipt
                                            number</span>
                                        <strong>PCAAS{{ $payment->id }}</strong>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <span
                                            style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 3px;">Date
                                            of transaction</span>
                                        {{ $payment->created_at->setTimezone('Asia/Kolkata')->format('d M Y') }}
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <span
                                            style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 3px;">Order
                                            #</span>
                                        {{ $payment->id }}
                                    </div>
                                    <div>
                                        <span
                                            style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 3px;">Delegate
                                            ID</span>
                                        {{ $membershipId }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
                            <thead>
                                <tr style="background: #f0f0f0;">
                                    <th style="border: 1px solid #000; padding: 10px; text-align: left; font-size: 14px;">
                                        S.No.</th>
                                    <th style="border: 1px solid #000; padding: 10px; text-align: left; font-size: 14px;">
                                        Particulars</th>
                                    <th style="border: 1px solid #000; padding: 10px; text-align: left; font-size: 14px;">
                                        HSN/SAC</th>
                                    <th style="border: 1px solid #000; padding: 10px; text-align: right; font-size: 14px;">
                                        Qty</th>
                                    <th style="border: 1px solid #000; padding: 10px; text-align: right; font-size: 14px;">
                                        Rate</th>
                                    <th style="border: 1px solid #000; padding: 10px; text-align: right; font-size: 14px;">
                                        Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #000; padding: 10px;">1.</td>
                                    <td style="border: 1px solid #000; padding: 10px;">
                                        @if ($payment->type == 'donation')
                                            Donation Contribution
                                        @elseif($payment->type == 'accompanying')
                                            Accompanying Person Charge
                                        @else
                                            Membership Fees
                                        @endif
                                    </td>
                                    <td style="border: 1px solid #000; padding: 10px;">998596</td>
                                    <td style="border: 1px solid #000; padding: 10px; text-align: right;">1</td>
                                    <td style="border: 1px solid #000; padding: 10px; text-align: right;">INR
                                        {{ number_format($payment->amount, 2) }}</td>
                                    <td style="border: 1px solid #000; padding: 10px; text-align: right;">INR
                                        {{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                <tr style="font-weight: bold; font-size: 16px;">
                                    <td colspan="5" style="border: 1px solid #000; padding: 10px; text-align: right;">Total
                                    </td>
                                    <td style="border: 1px solid #000; padding: 10px; text-align: right;">INR
                                        {{ number_format($payment->amount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="margin-bottom: 15px;">
                            <span
                                style="display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 5px;">Amount
                                chargeable (in words)</span>
                            <strong>{{ $amountWords ? $amountWords . ' only' : ucfirst($payment->amount) . ' INR only' }}</strong>
                        </div>

                        <div style="margin-top: 60px; text-align: right;">
                            <div style="display: inline-block; min-width: 200px; text-align: center;">


                                <img src="{{ url('images/sign.png') }}" style="width: 80px; margin-bottom: 5px;">

                                <div style="border-top: 1px solid #000; padding-top: 5px;">
                                    <div>Authorised Signatory</div>
                                </div>

                            </div>
                        </div>

                        <div style="margin-top: 30px; font-size: 12px; color: #666; text-align: center;">
                            This is a provisional receipt.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection