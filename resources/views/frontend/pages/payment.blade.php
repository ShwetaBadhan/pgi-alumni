@extends('frontend.layout.master')
@section('title', 'Payment | PGI Alumni')
@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap');

        .pgi-pay, .pgi-modal {
            --ink: #14263a; --teal: #1a1974; --teal-soft: #e4f1f0; --gold: #c8963e; --gold-soft: #fbf3e2;
            --paper: #f4f6f8; --line: #e3e8ee; --muted: #64748b; --danger: #b3261e;
            font-family: 'DM Sans', sans-serif; font-size: 16px; line-height: 1.55; color: var(--ink);
        }
        .pgi-pay { background: var(--paper); padding: 48px 0 56px; }
        .pgi-pay h5, .pgi-pay h6, .pgi-pay p, .pgi-pay td, .pgi-pay th, .pgi-pay label, .pgi-pay span, .pgi-pay small, .pgi-pay button,
        .pgi-modal h5, .pgi-modal label, .pgi-modal button, .pgi-modal span { font-family: 'DM Sans', sans-serif; }

        /* Cards */
        .pgi-card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(20,38,58,.04); margin-bottom: 24px; overflow: hidden; }
        .pgi-card-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; padding: 16px 24px; border-bottom: 1px solid var(--line); }
        .pgi-pay .pgi-card-head h5 { margin: 0; font-size: 18px; font-weight: 700; color: var(--ink); }
        .pgi-card-head.teal { background: var(--teal); border: 0; }
        .pgi-pay .pgi-card-head.teal h5 { color: #fff; }
        .pgi-card-head.green { background: #17693a; border: 0; }
        .pgi-pay .pgi-card-head.green h5 { color: #fff; }
        .pgi-card-body { padding: 24px; }
        .pgi-card-foot { padding: 16px 24px; border-top: 1px solid var(--line); background: #fafbfc; text-align: center; }

        /* Fee rows */
        .fee-row { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 16px 24px; border-top: 1px solid var(--line); flex-wrap: wrap; }
        .fee-row:first-child { border-top: 0; }
        .fee-row .lbl { font-weight: 600; font-size: 16px; }
        .fee-row .lbl small { display: block; color: var(--muted); font-weight: 400; font-size: 14px; }
        .fee-row .val { font-weight: 700; font-size: 16px; white-space: nowrap; }
        .fee-total { background: var(--teal-soft); }
        .fee-total .lbl { font-size: 18px; }
        .fee-total .val { font-family: 'Fraunces', serif; font-size: 26px; color: var(--teal); }

        /* Pills */
        .pgi-pill { display: inline-block; padding: 3px 12px; border-radius: 999px; font-size: 13px; font-weight: 600; white-space: nowrap; }
        .pill-yes { background: #dcf3e6; color: #17693a; }
        .pill-no { background: #eef1f5; color: var(--muted); }
        .pill-info { background: #dcecf9; color: #1d5a94; }
        .pill-warn { background: #fdecc8; color: #8a5a00; }

        /* Tables */
        .pgi-table { width: 100%; border-collapse: collapse; font-size: 15px; background: #fff; }
        .pgi-table th { background: var(--paper); color: var(--muted); font-size: 14px; font-weight: 600; text-align: left; padding: 12px 16px; white-space: nowrap; }
        .pgi-table td { padding: 14px 16px; border-top: 1px solid var(--line); vertical-align: middle; }
        .amount { font-weight: 700; color: var(--teal); white-space: nowrap; }
        .list-wrap { padding: 20px 24px; background: var(--paper); border-top: 1px solid var(--line); display: none; }
        .list-wrap h6 { font-size: 16px; font-weight: 700; margin-bottom: 12px; }
        .list-wrap .tbl-box { border: 1px solid var(--line); border-radius: 10px; overflow: hidden; }

        /* Buttons */
        .pgi-pay .btn-pgi, .pgi-modal .btn-pgi { background: var(--teal); color: #fff; border: 0; border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 15px; line-height: 1.4; cursor: pointer; transition: background .2s; }
        .pgi-pay .btn-pgi:hover, .pgi-modal .btn-pgi:hover { background: #4a478f; color: #fff; }
        .pgi-pay .btn-outline, .pgi-modal .btn-outline { background: #fff; color: var(--teal); border: 1.5px solid var(--teal); border-radius: 10px; padding: 9px 20px; font-weight: 600; font-size: 15px; cursor: pointer; }
        .pgi-pay .btn-outline:hover { background: var(--teal-soft); }
        .pgi-pay .btn-danger-soft { background: #fff; color: var(--danger); border: 1px solid #f0c9c6; border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 14px; cursor: pointer; }
        .pgi-pay .btn-danger-soft:hover { background: #fdf0ef; }
        .pgi-pay .btn-big { width: 100%; padding: 14px 20px; font-size: 17px; border-radius: 12px; }
        .pgi-modal .btn-light { background: #fff; border: 1px solid var(--line); color: var(--ink); border-radius: 10px; padding: 9px 20px; font-weight: 600; font-size: 15px; }
        .pgi-pay :focus-visible, .pgi-modal :focus-visible { outline: 3px solid rgba(15,107,107,.4); outline-offset: 2px; }

        /* Pay section */
        .qr-box { display: inline-block; padding: 16px; background: #fff; border: 2px solid var(--line); border-radius: 14px; }
        .breakup { text-align: left; background: var(--gold-soft); border: 1px solid #ecd9ab; border-radius: 12px; padding: 16px 18px; margin-top: 18px; font-size: 15px; }
        .breakup .line { display: flex; justify-content: space-between; gap: 12px; padding: 4px 0; }
        .breakup .line.total { border-top: 1px solid #e3cf9e; margin-top: 6px; padding-top: 10px; font-weight: 700; font-size: 17px; }
        .breakup .note { margin-top: 10px; color: #6b5a2c; font-size: 14px; }
        .step-title { font-family: 'Fraunces', serif; font-size: 20px; font-weight: 700; margin-bottom: 16px; }
        .pgi-pay .form-label { font-size: 15px; font-weight: 600; margin-bottom: 6px; }
        .pgi-pay .form-control, .pgi-modal .form-control { border-radius: 10px; min-height: 46px; font-size: 16px; }
        .warn-box { display: flex; gap: 12px; align-items: flex-start; background: #fdf0ef; border: 1px solid #f0c9c6; color: #7a1c16; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px; font-size: 15px; }
        .warn-box i { font-size: 20px; margin-top: 1px; }
        .confirm-box { display: flex; gap: 12px; align-items: flex-start; background: var(--paper); border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; margin-bottom: 18px; }
        .confirm-box input { width: 20px; height: 20px; margin-top: 3px; flex: none; accent-color: var(--teal); }
        .confirm-box label { font-size: 15px; font-weight: 500; }

        .done { text-align: center; padding: 36px 24px; }
        .done .tick { width: 64px; height: 64px; border-radius: 50%; background: #dcf3e6; color: #17693a; display: grid; place-items: center; font-size: 30px; margin: 0 auto 14px; }
        .done h5 { font-family: 'Fraunces', serif; font-size: 24px; margin-bottom: 8px; }
        .done p { font-size: 16px; margin-bottom: 8px; }
        .done .muted { color: var(--muted); font-size: 15px; }

        .pgi-pay .alert { border-radius: 12px; font-size: 15px; }

        /* Modals */
        .pgi-modal .modal-content { border: 0; border-radius: 16px; overflow: hidden; }
        .pgi-modal .modal-header { background: var(--ink); border: 0; padding: 18px 24px; }
        .pgi-modal .modal-title { font-family: 'Fraunces', serif; font-size: 22px; color: #fff; }
        .pgi-modal .btn-close { filter: invert(1); }
        .pgi-modal .modal-body { background: var(--paper); padding: 24px; }
        .pgi-modal .modal-footer { border-top: 1px solid var(--line); }
        .pgi-modal .q-block { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 16px 18px; margin-bottom: 16px; }
        .pgi-modal .q-title { display: block; font-size: 17px; font-weight: 700; margin-bottom: 10px; }
        .pgi-modal .form-label { font-size: 15px; font-weight: 600; margin-bottom: 6px; }
        .pgi-modal .form-label.small { font-size: 14px; }
        .pgi-modal .form-check-label { font-size: 16px; }
        .pgi-modal .form-check-input { width: 20px; height: 20px; margin-top: 2px; cursor: pointer; }
        .pgi-modal .form-check-input:checked { background-color: var(--teal); border-color: var(--teal); }
        .pgi-modal .form-check-inline { margin-right: 24px; }
        .pgi-modal .reg-option { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 2px solid var(--line); border-radius: 12px; background: #fff; margin-bottom: 10px; cursor: pointer; }
        .pgi-modal .reg-option:has(input:checked) { border-color: var(--teal); background: var(--teal-soft); }
        .pgi-modal .reg-option input { margin: 0; }
        .pgi-modal .reg-option span { font-size: 16px; font-weight: 600; }

        @media (max-width: 767px) {
            .pgi-pay { padding: 28px 0 40px; }
            .fee-row, .pgi-card-head, .pgi-card-body { padding-left: 16px; padding-right: 16px; }
        }
        @media (prefers-reduced-motion: reduce) { .pgi-pay *, .pgi-modal * { transition: none !important; } }
    </style>

    <!-- Breadcrumb -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Payment Details</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Payment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Content -->
    <div class="pgi-pay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Order summary -->
                    <div class="pgi-card">
                        <div class="pgi-card-head"><h5>Payment summary</h5></div>

                        <div class="fee-row">
                            <span class="lbl">Registration type</span>
                            <span class="val">{{ $user->registrationType->name ?? 'N/A' }}</span>
                        </div>
                        <div class="fee-row">
                            <span class="lbl">Membership fee</span>
                            <span class="val">INR {{ number_format($registrationCharge, 2) }}</span>
                        </div>
                        @if (str_contains($user->registrationType->name ?? '', 'Summit'))
                            <div class="fee-row">
                                <span class="lbl">Global PGI Alumni Summit 2026 fee</span>
                                <span class="val">INR 5,000.00</span>
                            </div>
                        @endif

                        <!-- Accompanying persons -->
                        <div class="fee-row">
                            <span class="lbl">
                                Accompanying persons
                                <small>{{ $user->accompanyingPersons->count() }} added</small>
                            </span>
                            <span class="d-flex align-items-center flex-wrap gap-2">
                                @if ($user->accompanyingPersons->isNotEmpty())
                                    <span class="val me-2">INR {{ number_format($accompanyingCharge, 2) }}</span>
                                @endif
                                <button type="button" class="btn-pgi" data-bs-toggle="modal" data-bs-target="#addAccompanyingModal">
                                    <i class="feather-plus"></i> Add person
                                </button>
                                @if ($user->accompanyingPersons->isNotEmpty())
                                    <button type="button" class="btn-outline" id="viewListBtn" onclick="toggleAccompanyingList()">
                                        <i class="feather-list"></i> View list
                                    </button>
                                @endif
                            </span>
                        </div>

                        @if ($user->accompanyingPersons->isNotEmpty())
                            <div id="accompanyingListSection" class="list-wrap" style="display: none;">
                                <h6>Accompanying persons list</h6>
                                <div class="tbl-box table-responsive">
                                    <table class="pgi-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Belongs to PGI</th>
                                                <th>Member</th>
                                                <th>Needs membership</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->accompanyingPersons as $index => $person)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="fw-semibold">{{ $person->title }} {{ $person->name }}</td>
                                                    <td>{{ $person->age ?? 'N/A' }}</td>
                                                    <td>{{ $person->gender ?? 'N/A' }}</td>
                                                    <td><span class="pgi-pill {{ $person->is_alumni ? 'pill-yes' : 'pill-no' }}">{{ $person->is_alumni ? 'Yes' : 'No' }}</span></td>
                                                    <td><span class="pgi-pill {{ $person->alumni_membership_id ? 'pill-info' : 'pill-no' }}">{{ $person->alumni_membership_id ? 'Yes' : 'No' }}</span></td>
                                                    <td><span class="pgi-pill {{ $person->wants_membership ? 'pill-warn' : 'pill-no' }}">{{ $person->wants_membership ? 'Yes' : 'No' }}</span></td>
                                                    <td class="amount">INR {{ number_format($person->charge, 2) }}</td>
                                                    <td>
                                                        <form action="{{ route('alumni.payment.delete-accompanying', $person->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to remove this person?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-danger-soft">
                                                                <i class="feather-trash-2"></i> Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="fee-row fee-total">
                            <span class="lbl">Total</span>
                            <span class="val">INR {{ number_format($totalAmount, 2) }}</span>
                        </div>
                        <div class="fee-row">
                            <span class="lbl">Status</span>
                            <span class="pgi-pill pill-warn">{{ ucfirst($user->status) }}</span>
                        </div>

                        <div class="pgi-card-foot">
                            <button type="button" class="btn-outline" data-bs-toggle="modal" data-bs-target="#editPreferenceModal">
                                <i class="feather-edit"></i> Edit preference
                            </button>
                        </div>
                    </div>

                    @if ($balanceDue > 0)
                        <div class="pgi-card">
                            <div class="pgi-card-head teal">
                                <h5><i class="feather-credit-card"></i> Pay the remaining balance via UPI</h5>
                            </div>
                            <div class="pgi-card-body">
                                @php
                                    $upiId = 'SBIBHIM.INSTANT94457614306650492@sbipay';
                                    $merchantName = 'PGI Alumni Society';

                                    $cleanAmount = number_format($balanceDue, 2, '.', '');
                                    $note = 'Balance Payment - ' . ($user->membership_id ?? 'New');

                                    $upiString =
                                        "upi://pay?pa={$upiId}&pn=" .
                                        urlencode($merchantName) .
                                        "&am={$cleanAmount}&cu=INR&tn=" .
                                        urlencode($note);
                                @endphp

                                <div class="row g-4">
                                    <!-- Step 1: scan -->
                                    <div class="col-md-5 text-center">
                                        <div class="step-title">Step 1: Scan and pay</div>
                                        <div class="qr-box">
                                            {!! QrCode::size(220)->generate($upiString) !!}
                                        </div>

                                        <div class="breakup">
                                            @if ($pendingAccCharge > 0)
                                                <div class="line"><span>New accompanying person charge</span><span>INR {{ number_format($pendingAccCharge, 2) }}</span></div>
                                            @endif
                                            @if ($pendingDonation > 0)
                                                <div class="line"><span>New donation</span><span>INR {{ number_format($pendingDonation, 2) }}</span></div>
                                            @endif
                                            <div class="line total"><span>Pay now (QR amount)</span><span>INR {{ number_format($balanceDue, 2) }}</span></div>
                                            <div class="note">
                                                You have paid INR {{ number_format($totalPaidEver, 2) }} so far. This QR code covers only the newly added items.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2: confirm -->
                                    <div class="col-md-7">
                                        <div class="step-title">Step 2: Confirm your payment</div>
                                        <form action="{{ route('alumni.payment.submit-utr') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">UPI transaction ID (UTR) *</label>
                                                <input type="text" name="payment_transaction_id" class="form-control"
                                                    placeholder="e.g., 324567890123" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Upload payment screenshot *</label>
                                                <input type="file" name="payment_screenshot" class="form-control"
                                                    accept="image/*,.pdf" required>
                                            </div>

                                            <div class="warn-box">
                                                <i class="feather-alert-triangle"></i>
                                                <span><strong>Warning:</strong> A fake UTR will get your payment rejected.</span>
                                            </div>

                                            <div class="confirm-box">
                                                <input type="checkbox" id="confirmPayment" name="confirm_payment" required>
                                                <label for="confirmPayment">
                                                    I confirm that I have transferred <strong>INR {{ number_format($balanceDue, 2) }}</strong> via UPI.
                                                </label>
                                            </div>

                                            <button type="submit" class="btn-pgi btn-big">
                                                <i class="feather-check-circle"></i> Submit payment details
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="pgi-card">
                            <div class="pgi-card-head green">
                                <h5><i class="feather-check-circle"></i> Payment completed</h5>
                            </div>
                            <div class="done">
                                <div class="tick"><i class="feather-check"></i></div>
                                <h5>Thank you!</h5>
                                <p>Your total payment of <strong>INR {{ number_format($totalAmount, 2) }}</strong> has been submitted.</p>
                                <p>Current status: <span class="pgi-pill pill-warn">{{ ucfirst($user->status) }}</span></p>
                                <p class="muted mt-3">Our admin team is verifying your payments. You will get a confirmation email once approved.</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Add Accompanying Person Modal -->
    <div class="modal fade pgi-modal" id="addAccompanyingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('alumni.payment.add-accompanying') }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add accompanying person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Step 1 -->
                        <div class="q-block">
                            <span class="q-title">Does the accompanying person belong to PGI?</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="belongs_to_pgi" id="belongsYes" value="1" onchange="togglePGIFields()">
                                <label class="form-check-label" for="belongsYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="belongs_to_pgi" id="belongsNo" value="0" onchange="togglePGIFields()">
                                <label class="form-check-label" for="belongsNo">No</label>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div id="hasMembershipSection" class="q-block" style="display: none;">
                            <span class="q-title">Does the accompanying person have a membership?</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_membership" id="hasMembershipYes" value="1" onchange="toggleMembershipFields()">
                                <label class="form-check-label" for="hasMembershipYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_membership" id="hasMembershipNo" value="0" onchange="toggleMembershipFields()">
                                <label class="form-check-label" for="hasMembershipNo">No</label>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div id="requiresMembershipSection" class="q-block" style="display: none;">
                            <span class="q-title">Does the accompanying person require a membership?</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_membership" id="requiresYes" value="1" onchange="toggleRequiresFields()">
                                <label class="form-check-label" for="requiresYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_membership" id="requiresNo" value="0" onchange="toggleRequiresFields()">
                                <label class="form-check-label" for="requiresNo">No</label>
                            </div>
                        </div>

                        <!-- Membership lookup -->
                        <div id="membershipLookupSection" class="q-block" style="display: none;">
                            <span class="q-title">Enter one of the details below</span>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Member ID</label>
                                    <input type="text" name="member_id" id="memberIdInput" class="form-control" placeholder="PCAAS1300">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">or Email</label>
                                    <input type="email" name="lookup_email" class="form-control" placeholder="email@example.com">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Contact number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">🇮🇳 +91</span>
                                        <input type="tel" name="lookup_contact" class="form-control" placeholder="9876543210">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn-pgi" onclick="checkMemberDetails()">
                                    <i class="feather-search"></i> Check member
                                </button>
                            </div>
                            <div id="memberLookupResult" class="mt-2"></div>
                        </div>

                        <!-- Contact -->
                        <div id="requiresContactSection" class="q-block" style="display: none;">
                            <span class="q-title">Enter their contact details</span>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">🇮🇳 +91</span>
                                        <input type="tel" name="contact_number" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="q-block mb-0">
                            <span class="q-title">Accompanying person details</span>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Designation *</label>
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="title" required>
                                            <option value="">Designation *</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Prof.">Prof.</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Full name *</label>
                                    <input type="text" name="full_name" id="fullNameInput" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Age *</label>
                                    <input type="number" name="age" class="form-control" min="1" max="150" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Gender *</label>
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="gender" required>
                                            <option value="">Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="is_alumni" id="isAlumniHidden" value="0">
                        <input type="hidden" name="wants_membership" id="wantsMembershipHidden" value="0">
                        <input type="hidden" name="alumni_membership_id" id="alumniMembershipIdHidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-pgi"><i class="feather-check"></i> Add person</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Preference Modal -->
    <div class="modal fade pgi-modal" id="editPreferenceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('alumni.payment.update-preference') }}" method="POST" class="w-100">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit preference</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="q-title" style="font-size:17px;font-weight:700;display:block;margin-bottom:12px;">Registration type *</span>
                        @php
                            $regTypes = \App\Models\RegistrationType::where('status', 'active')->get();
                        @endphp
                        @foreach ($regTypes as $regType)
                            <label class="reg-option" for="regType{{ $regType->id }}">
                                <input class="form-check-input" type="radio" name="registration_type_id"
                                    id="regType{{ $regType->id }}" value="{{ $regType->id }}"
                                    {{ $user->registration_type_id == $regType->id ? 'checked' : '' }}>
                                <span>{{ $regType->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-pgi"><i class="feather-check"></i> Save preference</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Toggle Accompanying List Visibility
        function toggleAccompanyingList() {
            const listSection = document.getElementById('accompanyingListSection');
            const viewListBtn = document.getElementById('viewListBtn');

            if (!listSection || !viewListBtn) {
                alert('No accompanying persons added yet!');
                return;
            }

            if (listSection.style.display === 'none') {
                listSection.style.display = 'block';
                viewListBtn.innerHTML = '<i class="feather-eye-off"></i> Hide list';
            } else {
                listSection.style.display = 'none';
                viewListBtn.innerHTML = '<i class="feather-list"></i> View list';
            }
        }

        // Toggle PGI fields
        function togglePGIFields() {
            const belongsYes = document.getElementById('belongsYes').checked;
            const hasMembershipSection = document.getElementById('hasMembershipSection');
            const requiresMembershipSection = document.getElementById('requiresMembershipSection');
            const requiresContactSection = document.getElementById('requiresContactSection');
            const membershipLookupSection = document.getElementById('membershipLookupSection');
            const isAlumniHidden = document.getElementById('isAlumniHidden');

            if (belongsYes) {
                hasMembershipSection.style.display = 'block';
                isAlumniHidden.value = '1';
            } else {
                hasMembershipSection.style.display = 'none';
                requiresMembershipSection.style.display = 'none';
                requiresContactSection.style.display = 'none';
                membershipLookupSection.style.display = 'none';
                isAlumniHidden.value = '0';
                document.getElementById('wantsMembershipHidden').value = '0';
            }
        }

        // Toggle membership fields
        function toggleMembershipFields() {
            const hasMembershipYes = document.getElementById('hasMembershipYes').checked;
            const requiresMembershipSection = document.getElementById('requiresMembershipSection');
            const requiresContactSection = document.getElementById('requiresContactSection');
            const membershipLookupSection = document.getElementById('membershipLookupSection');

            if (hasMembershipYes) {
                membershipLookupSection.style.display = 'block';
                requiresMembershipSection.style.display = 'none';
                requiresContactSection.style.display = 'none';
                document.getElementById('wantsMembershipHidden').value = '0';
            } else {
                membershipLookupSection.style.display = 'none';
                requiresMembershipSection.style.display = 'block';
            }
        }

        // Toggle requires membership fields
        function toggleRequiresFields() {
            const requiresYes = document.getElementById('requiresYes').checked;
            const requiresContactSection = document.getElementById('requiresContactSection');

            if (requiresYes) {
                requiresContactSection.style.display = 'block';
                document.getElementById('wantsMembershipHidden').value = '1';
            } else {
                requiresContactSection.style.display = 'none';
                document.getElementById('wantsMembershipHidden').value = '0';
            }
        }

        // Check member details via AJAX
        function checkMemberDetails() {
            const memberId = document.getElementById('memberIdInput').value.trim();
            const resultDiv = document.getElementById('memberLookupResult');
            const fullNameInput = document.getElementById('fullNameInput');
            const alumniMembershipIdHidden = document.getElementById('alumniMembershipIdHidden');

            if (!memberId) {
                resultDiv.innerHTML = '<div class="alert alert-warning">Please enter Member ID</div>';
                return;
            }

            resultDiv.innerHTML = '<div class="alert alert-info">Searching...</div>';

            fetch("{{ route('check.alumni.member') }}?membership_id=" + encodeURIComponent(memberId), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fullNameInput.value = data.name;
                        alumniMembershipIdHidden.value = memberId;
                        resultDiv.innerHTML =
                            '<div class="alert alert-success"><i class="feather-check-circle"></i> Member found: ' +
                            data.name + '</div>';
                    } else {
                        resultDiv.innerHTML = '<div class="alert alert-danger"><i class="feather-x-circle"></i> ' +
                            data.message + '</div>';
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = '<div class="alert alert-danger">Error checking member</div>';
                });
        }

        // Modal reset on close
        document.getElementById('addAccompanyingModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset();
            document.getElementById('memberLookupResult').innerHTML = '';
            document.getElementById('hasMembershipSection').style.display = 'none';
            document.getElementById('requiresMembershipSection').style.display = 'none';
            document.getElementById('requiresContactSection').style.display = 'none';
            document.getElementById('membershipLookupSection').style.display = 'none';
            document.getElementById('isAlumniHidden').value = '0';
            document.getElementById('wantsMembershipHidden').value = '0';
        });
    </script>
@endpush