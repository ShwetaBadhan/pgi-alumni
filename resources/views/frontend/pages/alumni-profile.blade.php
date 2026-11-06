@extends('frontend.layout.master')
@section('title', 'My Profile | PGI Alumni')
@section('content')

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

    <!-- Profile Content -->
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5">

                <!-- Left Sidebar -->
                <div class="col-lg-4">
                    <div class="card shadow-sm p-4 text-center mb-4">
                        @if ($user->documents && $user->documents->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->documents->profile_photo_path) }}"
                                class="rounded-circle mb-3 mx-auto d-block"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto bg-primary text-white"
                                style="width: 120px; height: 120px; font-size: 40px;">
                                {{ strtoupper(substr($user->profile->firstname ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <h5 class="fw-bold mb-1">
                            {{ strtoupper(($user->profile->title ?? '') . ' ' . ($user->profile->firstname ?? '') . ' ' . ($user->profile->lastname ?? '')) }}
                        </h5>
                        <p class="text-muted small mb-2">Mobile: +91{{ $user->profile->contact_number ?? 'N/A' }}</p>
                        <p class="text-muted small mb-3">Email: {{ $user->email }}</p>

                        <div class="d-grid gap-2">
                            {{-- <a href="#" class="btn btn-sm btn-primary">Click Here For Accommodations</a>
                            <button class="btn btn-sm btn-warning">Reset Password</button> --}}
                            <form action="{{ route('alumni-logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger w-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-8">

                    <!-- Special Conclave Benefit Banner -->
                    <div class="alert alert-success d-flex align-items-center mb-4 border-success" role="alert">
                        <i class="feather icon-gift fs-1 me-3 text-success"></i>
                        <div>
                            <h6 class="fw-bold mb-1">🎉 Special Benefit Unlocked!</h6>
                            <p class="mb-0 small">
                                As a valued member, you can attend the <strong>Global PGI Alumni Conclave absolutely
                                    FREE</strong> with your membership worth Rs. 12,000!
                            </p>
                        </div>
                    </div>

                    <!-- Personal Details Table -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <table class="table table-borderless table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold" style="width: 40%;">Email</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="fw-semibold">Mobile</td>
                                        <td>+91{{ $user->profile->contact_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">WhatsApp Contact Number</td>
                                        <td colspan="3">
                                            +91{{ $user->profile->whatsapp_number ?? ($user->profile->contact_number ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Degree Completed from PGIMER</td>
                                        <td colspan="3">{{ $user->profile->degree_completed ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Department</td>
                                        <td colspan="3">{{ $user->profile->department ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Year of Passing</td>
                                        <td colspan="3">{{ $user->profile->year_of_passing ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Year of Joining as Faculty</td>
                                        <td colspan="3">{{ $user->profile->year_of_joining_faculty ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Country of Residence</td>
                                        <td colspan="3">{{ $user->profile->residence_country ?? 'NA' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ✅ Accompanying Persons Section (Same as Payment Page) -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Accompanying Persons</h6>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addAccompanyingModal">
                                <i class="feather icon-plus"></i> Add Person
                            </button>
                        </div>
                        <div class="card-body p-0">
                            @if ($user->accompanyingPersons->isNotEmpty())
                                <div class="p-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0 bg-white">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Name</th>
                                                    <th>Age</th>
                                                    <th>Belong to PGI</th>
                                                    <th>Member</th>
                                                    <th>Need Membership</th>
                                                    <th>Gender</th>
                                                    <th>Amount</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user->accompanyingPersons as $index => $person)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $person->title }} {{ $person->name }}</td>
                                                        <td>{{ $person->age ?? 'N/A' }}</td>
                                                        <td>
                                                            @if ($person->is_alumni)
                                                                <span class="badge bg-success">Yes</span>
                                                            @else
                                                                <span class="badge bg-secondary">No</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($person->alumni_membership_id)
                                                                <span class="badge bg-info">Yes</span>
                                                            @else
                                                                <span class="badge bg-secondary">No</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($person->wants_membership)
                                                                <span class="badge bg-warning text-dark">Yes</span>
                                                            @else
                                                                <span class="badge bg-secondary">No</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $person->gender ?? 'N/A' }}</td>
                                                        <td class="fw-bold text-success">INR
                                                            {{ number_format($person->charge, 2) }}
                                                        </td>
                                                        {{-- <td>
                                                            <form
                                                                action="{{ route('alumni.payment.delete-accompanying', $person->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to remove this person?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="feather icon-trash-2"></i> Remove
                                                                </button>
                                                            </form>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted text-center py-3 mb-0">No accompanying persons added yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Payment History & Receipts -->
                    @if ($user->payments->isNotEmpty())
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Payment History & Receipts</h6>
                                @if ($user->payments->where('status', 'pending')->isNotEmpty())
                                    <a href="{{ route('alumni.payment') }}" class="btn btn-sm btn-warning text-dark">
                                        <i class="feather icon-credit-card"></i> Complete Pending Payments
                                    </a>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="table-light">
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
                                                    <td>{{ $user->membership_id ?? 'PCAAS' . $user->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($payment->type == 'donation')
                                                            <span class="badge text-white"
                                                                style="background-color: #6f42c1;">Donation</span>
                                                        @elseif ($payment->type == 'accompanying')
                                                            <span class="badge text-white"
                                                                style="background-color: #17a2b8;">Accompanying
                                                                Person</span>
                                                        @else
                                                            <span class="badge bg-primary">Membership Fee</span>
                                                        @endif
                                                    </td>
                                                    <td class="fw-bold text-success">INR
                                                        {{ number_format($payment->amount, 2) }}
                                                    </td>
                                                    <td>
                                                        @if ($payment->status == 'pending')
                                                            <span class="badge bg-warning text-dark">Under
                                                                Verification</span>
                                                        @elseif($payment->status == 'success')
                                                            <span class="badge bg-success">Verified</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Functional Donation Section -->
                    <div class="card shadow-sm mb-4 bg-light">
                        <div class="card-body">
                            @php
                                $hasDonated = $user
                                    ->payments()
                                    ->where('type', 'donation')
                                    ->where('status', 'success')
                                    ->exists();
                            @endphp


                            <h6 class="fw-bold mb-3">Please support the PGI Alumni Society well-being through
                                meaningful contributions</h6>
                            <form action="{{ route('alumni.donate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="1000"
                                            id="donate1000" required>
                                        <label class="form-check-label" for="donate1000">INR 1,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="2000"
                                            id="donate2000">
                                        <label class="form-check-label" for="donate2000">INR 2,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="3000"
                                            id="donate3000">
                                        <label class="form-check-label" for="donate3000">INR 3,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="4000"
                                            id="donate4000">
                                        <label class="form-check-label" for="donate4000">INR 4,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="5000"
                                            id="donate5000">
                                        <label class="form-check-label" for="donate5000">INR 5,000.00</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="feather icon-heart"></i> Proceed to Donate
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Add Accompanying Person Modal (Exact Copy from Payment Page) -->
    <div class="modal fade" id="addAccompanyingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('alumni.payment.add-accompanying') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Accompanying Person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Step 1: Belongs to PGI? -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Does the accompanying person belong to PGI?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="belongs_to_pgi" id="belongsYes" value="1"
                                    onchange="togglePGIFields()">
                                <label class="form-check-label" for="belongsYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="belongs_to_pgi" id="belongsNo" value="0"
                                    onchange="togglePGIFields()">
                                <label class="form-check-label" for="belongsNo">No</label>
                            </div>
                        </div>

                        <!-- Step 2: Has Membership? -->
                        <div id="hasMembershipSection" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">Does the accompanying person have a membership?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_membership" id="hasMembershipYes"
                                    value="1" onchange="toggleMembershipFields()">
                                <label class="form-check-label" for="hasMembershipYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_membership" id="hasMembershipNo"
                                    value="0" onchange="toggleMembershipFields()">
                                <label class="form-check-label" for="hasMembershipNo">No</label>
                            </div>
                        </div>

                        <!-- Step 3: Requires Membership? -->
                        <div id="requiresMembershipSection" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">Does the accompanying person require a membership?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_membership" id="requiresYes"
                                    value="1" onchange="toggleRequiresFields()">
                                <label class="form-check-label" for="requiresYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_membership" id="requiresNo"
                                    value="0" onchange="toggleRequiresFields()">
                                <label class="form-check-label" for="requiresNo">No</label>
                            </div>
                        </div>

                        <!-- Membership Lookup Fields -->
                        <div id="membershipLookupSection" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">Enter one of below details</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Member ID</label>
                                    <input type="text" name="member_id" id="memberIdInput" class="form-control"
                                        placeholder="PCAAS1300">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">or Email</label>
                                    <input type="email" name="lookup_email" class="form-control"
                                        placeholder="email@example.com">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Contact Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">🇮🇳 +91</span>
                                        <input type="tel" name="lookup_contact" class="form-control"
                                            placeholder="9876543210">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-info btn-sm" onclick="checkMemberDetails()">
                                    <i class="feather icon-search"></i> Check Member
                                </button>
                            </div>
                            <div id="memberLookupResult" class="mt-2"></div>
                        </div>

                        <!-- Contact Fields -->
                        <div id="requiresContactSection" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">Enter below details</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">🇮 +91</span>
                                        <input type="tel" name="contact_number" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Accompanying Person Details -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Accompanying Person details</label>
                        </div>
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
                                <label class="form-label">Full Name *</label>
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

                        <!-- Hidden fields -->
                        <input type="hidden" name="is_alumni" id="isAlumniHidden" value="0">
                        <input type="hidden" name="wants_membership" id="wantsMembershipHidden" value="0">
                        <input type="hidden" name="alumni_membership_id" id="alumniMembershipIdHidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="feather icon-check"></i> Submit
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
                            '<div class="alert alert-success"><i class="feather icon-check-circle"></i> Member found: ' +
                            data.name + '</div>';
                    } else {
                        resultDiv.innerHTML = '<div class="alert alert-danger"><i class="feather icon-x-circle"></i> ' +
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