@extends('frontend.layout.master')
@section('title', 'My Profile | PGI Alumni')
@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap');

        .pgi-profile {
            --ink: #14263a;
            --teal: #1a1974;
            --teal-soft: #e4f1f0;
            --gold: #c8963e;
            --gold-soft: #fbf3e2;
            --paper: #f4f6f8;
            --line: #e3e8ee;
            --muted: #64748b;
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
        }

        .pgi-profile h1, .pgi-profile h2, .pgi-profile h3, .pgi-profile .serif { font-family: 'Fraunces', serif; }

        .pgi-profile { padding: 48px 0 24px; }
        .pgi-wrap { padding-bottom: 40px; }

        /* Cards */
        .pgi-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(20, 38, 58, .04);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .pgi-card-head {
            display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;
            padding: 16px 22px;
            border-bottom: 1px solid var(--line);
        }
        .pgi-card-head h6 { margin: 0; font-size: 16.8px; font-weight: 700; color: var(--ink); }
        .pgi-card-body { padding: 22px; }

        /* Identity card */
        .pgi-id { text-align: center; padding: 30px 22px 24px; }
        .pgi-avatar {
            width: 124px; height: 124px; border-radius: 50%;
            object-fit: cover; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center;
            border: 4px solid #fff; box-shadow: 0 0 0 2px var(--gold);
            background: var(--teal); color: #fff; font: 700 44px 'Fraunces', serif;
        }
        .pgi-id h5 { font-family: 'Fraunces', serif; font-size: 20.8px; margin-bottom: 8px; line-height: 1.3; }
        .pgi-chip {
            display: inline-block; padding: 4px 12px; border-radius: 999px;
            background: var(--teal-soft); color: var(--teal); font-size: 12.8px; font-weight: 600; margin-bottom: 18px;
        }
        .pgi-contact { text-align: left; border-top: 1px solid var(--line); padding-top: 16px; margin-bottom: 18px; }
        .pgi-contact div { display: flex; gap: 12px; align-items: flex-start; padding: 8px 0; font-size: 14.72px; word-break: break-word; }
        .pgi-contact i { color: var(--teal); margin-top: 3px; }
        .pgi-contact small { display: block; color: var(--muted); font-size: 12px; }

        /* Conclave banner */
        .pgi-banner {
            display: flex; gap: 18px; align-items: center;
            background: var(--gold-soft); border: 1px solid #ecd9ab; border-left: 5px solid var(--gold);
            border-radius: 14px; padding: 20px 24px; margin-bottom: 24px;
        }
        .pgi-banner .badge-ico {
            flex: none; width: 52px; height: 52px; border-radius: 50%;
            background: var(--gold); color: #fff; display: grid; place-items: center; font-size: 24px;
        }
        .pgi-banner h6 { font-family: 'Fraunces', serif; font-size: 18.4px; margin-bottom: 4px; }
        .pgi-banner p { margin: 0; color: #5b4a22; font-size: 15.2px; }

        /* Details grid */
        .pgi-details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0; }
        .pgi-details .item { padding: 16px 22px; border-bottom: 1px solid var(--line); }
        .pgi-details .item:nth-child(odd) { border-right: 1px solid var(--line); }
        .pgi-details .item.full { grid-column: 1 / -1; border-right: 0; }
        .pgi-details dt { color: var(--muted); font-size: 12.8px; font-weight: 500; margin-bottom: 3px; }
        .pgi-details dd { margin: 0; font-weight: 600; word-break: break-word; }

        /* Tables */
        .pgi-table { width: 100%; border-collapse: collapse; font-size: 14.72px; }
        .pgi-table th {
            background: var(--paper); color: var(--muted); font-size: 12.8px; font-weight: 600;
            text-align: left; padding: 12px 16px; white-space: nowrap;
        }
        .pgi-table td { padding: 14px 16px; border-top: 1px solid var(--line); vertical-align: middle; }
        .pgi-table tbody tr:hover { background: #fafbfc; }
        .amount { font-weight: 700; color: var(--teal); white-space: nowrap; }

        .pgi-pill { display: inline-block; padding: 3px 11px; border-radius: 999px; font-size: 12.48px; font-weight: 600; white-space: nowrap; }
        .pill-yes { background: #dcf3e6; color: #17693a; }
        .pill-no { background: #eef1f5; color: var(--muted); }
        .pill-info { background: #dcecf9; color: #1d5a94; }
        .pill-warn { background: #fdecc8; color: #8a5a00; }
        .pill-donation { background: #ece4f8; color: #5b34a0; }
        .pill-accomp { background: #d9f1f5; color: #0e6272; }
        .pill-member { background: #dfe8f7; color: #2a4b8d; }

        .empty-state { text-align: center; padding: 36px 20px; color: var(--muted); }
        .empty-state i { font-size: 32px; color: #b8c2cf; display: block; margin-bottom: 8px; }

        /* Buttons */
        .pgi-profile .btn-pgi {
            background: var(--teal); color: #fff; border: 0; border-radius: 10px;
            padding: 9px 18px; font-weight: 600; font-size: 14.4px; transition: background .2s;
        }
        .pgi-profile .btn-pgi:hover { background: #0b5555; color: #fff; }
        .pgi-profile .btn-gold { background: var(--gold); color: #fff; border: 0; border-radius: 10px; padding: 9px 18px; font-weight: 600; font-size: 14.4px; }
        .pgi-profile .btn-gold:hover { background: #b0822f; color: #fff; }
        .pgi-profile .btn-ghost {
            background: #fff; color: #b3261e; border: 1px solid #f0c9c6; border-radius: 10px;
            padding: 9px 18px; font-weight: 600; font-size: 14.4px; width: 100%;
        }
        .pgi-profile .btn-ghost:hover { background: #fdf0ef; }
        .pgi-profile :focus-visible { outline: 3px solid rgba(15, 107, 107, .4); outline-offset: 2px; }

        /* Donation tiles */
        .donate-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; margin-bottom: 18px; }
        .donate-tile { position: relative; }
        .donate-tile input { position: absolute; opacity: 0; inset: 0; cursor: pointer; }
        .donate-tile span {
            display: block; text-align: center; padding: 14px 8px; border: 2px solid var(--line);
            border-radius: 12px; font-weight: 700; background: #fff; transition: border-color .15s, background .15s;
        }
        .donate-tile input:checked + span { border-color: var(--teal); background: var(--teal-soft); color: var(--teal); }
        .donate-tile input:focus-visible + span { outline: 3px solid rgba(15, 107, 107, .4); }
        .donate-tile span small { display: block; font-weight: 500; color: var(--muted); font-size: 11.52px; }

        /* Modal */
        .pgi-modal {
            --ink: #14263a; --teal: #1a1974; --teal-soft: #e4f1f0; --gold: #c8963e;
            --paper: #f4f6f8; --line: #e3e8ee; --muted: #64748b; color: var(--ink);
        }
        .pgi-modal .btn-pgi {
            background: var(--teal); color: #fff; border: 0; border-radius: 10px;
            padding: 10px 22px; font-weight: 600; transition: background .2s; cursor: pointer;
        }
        .pgi-modal .btn-pgi:hover { background: #0b5555; color: #fff; }
        .pgi-modal .btn-light { background: #fff; border: 1px solid var(--line); color: var(--ink); }
        .pgi-modal :focus-visible { outline: 3px solid rgba(15, 107, 107, .4); outline-offset: 2px; }
        .pgi-modal .form-check-input { width: 20px; height: 20px; margin-top: 2px; cursor: pointer; }
        .pgi-modal .form-check-input:checked { background-color: var(--teal); border-color: var(--teal); }
        .pgi-modal .form-check-inline { margin-right: 24px; }
        .pgi-modal .modal-header .modal-title { color: #fff; }

        .pgi-modal .modal-content { border: 0; border-radius: 16px; overflow: hidden; }
        .pgi-modal .modal-header { background: var(--ink); color: #fff; border: 0; padding: 18px 24px; }
        .pgi-modal .modal-title { font-family: 'Fraunces', serif; color: #fff; }
        .pgi-modal .btn-close { filter: invert(1); }
        .pgi-modal .modal-body { background: var(--paper); padding: 24px; }
        .pgi-modal .q-block { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 16px 18px; margin-bottom: 16px; }
        .pgi-modal .form-control { border-radius: 10px; min-height: 45px; }
        .pgi-modal .modal-footer { border-top: 1px solid var(--line); }


        /* Explicit type scale (overrides theme defaults) */
        .pgi-profile { font-size: 16px; line-height: 1.55; }
        .pgi-profile h5, .pgi-profile h6, .pgi-profile dt, .pgi-profile dd, .pgi-profile th, .pgi-profile td,
        .pgi-profile label, .pgi-profile small, .pgi-profile button, .pgi-profile p, .pgi-profile span { font-family: 'DM Sans', sans-serif; }
        .pgi-profile .pgi-id h5 { font-family: 'Fraunces', serif; font-size: 22px; font-weight: 700; }
        .pgi-profile .pgi-banner h6 { font-family: 'Fraunces', serif; font-size: 20px; font-weight: 700; }
        .pgi-profile .pgi-banner p { font-size: 16px; line-height: 1.5; }
        .pgi-profile .pgi-card-head h6 { font-size: 18px; font-weight: 700; }
        .pgi-profile .pgi-chip { font-size: 14px; }
        .pgi-profile .pgi-contact div { font-size: 16px; }
        .pgi-profile .pgi-contact small { font-size: 13px; margin-bottom: 1px; }
        .pgi-profile .pgi-contact i { font-size: 18px; }
        .pgi-profile .pgi-details dt { font-size: 14px; font-weight: 500; }
        .pgi-profile .pgi-details dd { font-size: 17px; font-weight: 600; line-height: 1.4; }
        .pgi-profile .pgi-table th { font-size: 14px; }
        .pgi-profile .pgi-table td { font-size: 15px; }
        .pgi-profile .pgi-pill { font-size: 13px; }
        .pgi-profile .donate-tile span { font-size: 20px; }
        .pgi-profile .donate-tile span small { font-size: 12px; }
        .pgi-profile .btn-pgi, .pgi-profile .btn-gold, .pgi-profile .btn-ghost { font-size: 15px; line-height: 1.4; }
        .pgi-profile .banner-ico i, .pgi-profile .badge-ico i { font-size: 26px; line-height: 1; }
        .pgi-modal { font-family: 'DM Sans', sans-serif; font-size: 16px; }
        .pgi-modal .form-label { font-size: 15px; font-weight: 600; margin-bottom: 6px; }
        .pgi-modal .form-label.small { font-size: 14px; }
        .pgi-modal .form-check-label { font-size: 16px; }
        .pgi-modal .modal-title { font-size: 22px; }
        .pgi-modal .form-control { font-size: 16px; }
        .pgi-modal .q-block > .form-label.fw-bold { font-size: 17px; font-weight: 700; display: block; margin-bottom: 10px; }
        .pgi-modal .btn-pgi, .pgi-modal .btn-light { font-size: 15px; }
        .pgi-modal .btn-light { border-radius: 10px; padding: 9px 18px; font-weight: 600; }

        @media (max-width: 767px) {
            .pgi-details { grid-template-columns: 1fr; }
            .pgi-details .item:nth-child(odd) { border-right: 0; }
            .pgi-banner { flex-direction: column; text-align: center; }
        }
        @media (prefers-reduced-motion: reduce) { .pgi-profile * { transition: none !important; } }
    </style>

    @php
        $p = $user->profile;
        $fullName = trim(($p->title ?? '') . ' ' . ($p->firstname ?? '') . ' ' . ($p->lastname ?? ''));
        $details = [
            ['Degree completed from PGIMER', $p->degree_completed ?? 'NA', true],
            ['Department', $p->department ?? 'NA', false],
            ['Year of passing', $p->year_of_passing ?? 'NA', false],
            ['Year of joining as faculty', $p->year_of_joining_faculty ?? 'NA', false],
            ['Country of residence', $p->residence_country ?? 'NA', false],
        ];
    @endphp

    <!-- Breadcrumb -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">My Profile</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pgi-profile">

        <div class="container pgi-wrap">
            <div class="row g-4">

                <!-- Left Sidebar -->
                <div class="col-lg-4">
                    <div class="pgi-card pgi-id">
                        @if ($user->documents && $user->documents->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->documents->profile_photo_path) }}"
                                class="pgi-avatar" alt="Profile photo">
                        @else
                            <div class="pgi-avatar">{{ strtoupper(substr($p->firstname ?? 'U', 0, 1)) }}</div>
                        @endif

                        <h5>{{ strtoupper($fullName) }}</h5>
                        <span class="pgi-chip">{{ $user->membership_id ?? 'PCAAS' . $user->id }}</span>

                        <div class="pgi-contact">
                            <div>
                                <i class="feather-mail"></i>
                                <span><small>Email</small>{{ $user->email }}</span>
                            </div>
                            <div>
                                <i class="feather-phone"></i>
                                <span><small>Mobile</small>+91{{ $p->contact_number ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <i class="feather-message-circle"></i>
                                <span><small>WhatsApp</small>+91{{ $p->whatsapp_number ?? ($p->contact_number ?? 'N/A') }}</span>
                            </div>
                        </div>

                        <form action="{{ route('alumni-logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-ghost">Log out</button>
                        </form>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-8">

                    <!-- Conclave Benefit -->
                    <div class="pgi-banner" role="status">
                        <div class="badge-ico"><i class="feather-gift"></i></div>
                        <div>
                            <h6>Your membership includes free conclave entry</h6>
                            <p>You can attend the <strong>Global PGI Alumni Conclave at no cost</strong>. Your membership is worth Rs. 12,000.</p>
                        </div>
                    </div>

                    <!-- Personal Details -->
                    <div class="pgi-card">
                        <div class="pgi-card-head"><h6>Personal details</h6></div>
                        <dl class="pgi-details mb-0">
                            @foreach ($details as [$label, $value, $full])
                                <div class="item {{ $full ? 'full' : '' }}">
                                    <dt>{{ $label }}</dt>
                                    <dd>{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <!-- Accompanying Persons -->
                    <div class="pgi-card">
                        <div class="pgi-card-head">
                            <h6>Accompanying persons</h6>
                            <button class="btn-pgi" data-bs-toggle="modal" data-bs-target="#addAccompanyingModal">
                                <i class="feather-plus"></i> Add person
                            </button>
                        </div>
                        @if ($user->accompanyingPersons->isNotEmpty())
                            <div class="table-responsive">
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="feather-users"></i>
                                No accompanying persons yet. Add anyone joining you at the conclave.
                            </div>
                        @endif
                    </div>

                    <!-- Payment History -->
                    @if ($user->payments->isNotEmpty())
                        <div class="pgi-card">
                            <div class="pgi-card-head">
                                <h6>Payment history & receipts</h6>
                                @if ($user->payments->where('status', 'pending')->isNotEmpty())
                                    <a href="{{ route('alumni.payment') }}" class="btn-gold">
                                        <i class="feather-credit-card"></i> Complete pending payments
                                    </a>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="pgi-table">
                                    <thead>
                                        <tr>
                                            <th>Receipt ID</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->payments->sortByDesc('created_at') as $payment)
                                            <tr>
                                                <td class="fw-semibold">{{ $user->membership_id ?? 'PCAAS' . $user->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                                                <td>
                                                    @if ($payment->type == 'donation')
                                                        <span class="pgi-pill pill-donation">Donation</span>
                                                    @elseif ($payment->type == 'accompanying')
                                                        <span class="pgi-pill pill-accomp">Accompanying person</span>
                                                    @else
                                                        <span class="pgi-pill pill-member">Membership fee</span>
                                                    @endif
                                                </td>
                                                <td class="amount">INR {{ number_format($payment->amount, 2) }}</td>
                                                <td>
                                                    @if ($payment->status == 'pending')
                                                        <span class="pgi-pill pill-warn">Under verification</span>
                                                    @elseif($payment->status == 'success')
                                                        <span class="pgi-pill pill-yes">Verified</span>
                                                    @else
                                                        <span class="pgi-pill pill-no">{{ ucfirst($payment->status) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Donation -->
                    <div class="pgi-card">
                        <div class="pgi-card-head"><h6>Support the PGI Alumni Society</h6></div>
                        <div class="pgi-card-body">
                            <p class="text-muted mb-3">Choose an amount to contribute to the well-being of the alumni community.</p>
                            <form action="{{ route('alumni.donate') }}" method="POST">
                                @csrf
                                <div class="donate-grid">
                                    @foreach ([1000, 2000, 3000, 4000, 5000] as $amt)
                                        <label class="donate-tile">
                                            <input type="radio" name="donation_amount" value="{{ $amt }}"
                                                id="donate{{ $amt }}" {{ $loop->first ? 'required' : '' }}>
                                            <span><small>INR</small>{{ number_format($amt) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn-pgi">
                                    <i class="feather-heart"></i> Donate
                                </button>
                            </form>
                        </div>
                    </div>

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
                            <label class="form-label fw-bold">Does the accompanying person belong to PGI?</label><br>
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
                            <label class="form-label fw-bold">Does the accompanying person have a membership?</label><br>
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
                            <label class="form-label fw-bold">Does the accompanying person require a membership?</label><br>
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
                            <label class="form-label fw-bold">Enter one of the details below</label>
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
                            <label class="form-label fw-bold">Enter their contact details</label>
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
                            <label class="form-label fw-bold">Accompanying person details</label>
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
                        <button type="submit" class="btn-pgi">
                            <i class="feather-check"></i> Add person
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
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
        document.getElementById('addAccompanyingModal').addEventListener('hidden.bs.modal', function () {
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