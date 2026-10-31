@extends('frontend.layout.master')
@section('title', 'Payment | PGI Alumni')
@section('content')

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
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Payment Details Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Payment Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">Paying for type of registration:</td>
                                        <td class="text-end">{{ $user->registrationType->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Membership Fee:</td>
                                        <td class="text-end">INR {{ number_format($registrationCharge, 2) }}</td>
                                    </tr>
                                    @if (str_contains($user->registrationType->name ?? '', 'Summit'))
                                        <tr class="border-top">
                                            <td class="fw-semibold">Global PGI Alumni Summit 2026 Fee:</td>
                                            <td class="text-end">INR 5,000.00</td>
                                        </tr>
                                    @endif

                                    <!-- Accompanying Persons Section -->
                                    <tr class="border-top">
                                        <td class="fw-semibold">
                                            {{ $user->accompanyingPersons->count() }} Accompanying Person Charge:
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                                    data-bs-target="#addAccompanyingModal">
                                                    <i class="feather icon-plus"></i> Add Accompanying Person
                                                </button>
                                                @if ($user->accompanyingPersons->isNotEmpty())
                                                    <button class="btn btn-sm btn-primary" id="viewListBtn"
                                                        onclick="toggleAccompanyingList()">
                                                        <i class="feather icon-list"></i> View List
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Accompanying Persons Total -->
                                    @if ($user->accompanyingPersons->isNotEmpty())
                                        <tr class="border-top">
                                            <td class="fw-bold text-end" colspan="2">
                                                INR {{ number_format($accompanyingCharge, 2) }}
                                            </td>
                                        </tr>
                                    @endif

                                    <tr class="border-top">
                                        <td class="fw-bold">Total:</td>
                                        <td class="text-end fw-bold text-primary fs-5">INR
                                            {{ number_format($totalAmount, 2) }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Status:</td>
                                        <td class="text-end">
                                            <span class="badge bg-warning text-dark">{{ ucfirst($user->status) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Accompanying Persons List (Initially Hidden) -->
                        @if ($user->accompanyingPersons->isNotEmpty())
                            <div id="accompanyingListSection" class="card-body border-top" style="display: none;">
                                <h6 class="fw-bold mb-3">Accompanying Persons List</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
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
                                                <th>Action</th>
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
                                                        {{ number_format($person->charge, 2) }}</td>
                                                    <td>
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
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="card-footer text-center">
                            <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal"
                                data-bs-target="#editPreferenceModal">
                                <i class="feather icon-edit"></i> Edit Preference
                            </button>
                            <br>
                            <button class="btn btn-warning mt-2">
                                <i class="feather icon-credit-card"></i> Click to Pay Now
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Accompanying Person Modal -->
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
                                <input class="form-check-input" type="radio" name="belongs_to_pgi" id="belongsYes"
                                    value="1" onchange="togglePGIFields()">
                                <label class="form-check-label" for="belongsYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="belongs_to_pgi" id="belongsNo"
                                    value="0" onchange="togglePGIFields()">
                                <label class="form-check-label" for="belongsNo">No</label>
                            </div>
                        </div>

                        <!-- Step 2: Has Membership? -->
                        <div id="hasMembershipSection" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">Does the accompanying person have a membership?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_membership"
                                    id="hasMembershipYes" value="1" onchange="toggleMembershipFields()">
                                <label class="form-check-label" for="hasMembershipYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_membership"
                                    id="hasMembershipNo" value="0" onchange="toggleMembershipFields()">
                                <label class="form-check-label" for="hasMembershipNo">No</label>
                            </div>
                        </div>

                        <!-- Step 3: Requires Membership? -->
                        <div id="requiresMembershipSection" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">Does the accompanying person require a membership?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_membership"
                                    id="requiresYes" value="1" onchange="toggleRequiresFields()">
                                <label class="form-check-label" for="requiresYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="requires_membership"
                                    id="requiresNo" value="0" onchange="toggleRequiresFields()">
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
                                <input type="number" name="age" class="form-control" min="1" max="150"
                                    required>
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
    <!-- Edit Preference Modal (Dynamic) -->
    <div class="modal fade" id="editPreferenceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('alumni.payment.update-preference') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Preference</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Registration Type *</label>
                            @php
                                $regTypes = \App\Models\RegistrationType::where('status', 'active')->get();
                            @endphp
                            @foreach ($regTypes as $index => $regType)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="registration_type_id"
                                        id="regType{{ $regType->id }}" value="{{ $regType->id }}"
                                        {{ $user->registration_type_id == $regType->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="regType{{ $regType->id }}">
                                        {{ $regType->name }}
                                        
                                    </label>
                                </div>
                            @endforeach
                            
                        </div>
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
</div>@endsection

@push('scripts')
    <script>
        // Toggle Accompanying List Visibility
        // Toggle Accompanying List Visibility
        function toggleAccompanyingList() {
            const listSection = document.getElementById('accompanyingListSection');
            const viewListBtn = document.getElementById('viewListBtn');

            // Check if elements exist
            if (!listSection || !viewListBtn) {
                alert('No accompanying persons added yet!');
                return;
            }

            if (listSection.style.display === 'none') {
                listSection.style.display = 'block';
                viewListBtn.innerHTML = '<i class="feather icon-eye-off"></i> Hide List';
                viewListBtn.classList.remove('btn-primary');
                viewListBtn.classList.add('btn-secondary');
            } else {
                listSection.style.display = 'none';
                viewListBtn.innerHTML = '<i class="feather icon-list"></i> View List';
                viewListBtn.classList.remove('btn-secondary');
                viewListBtn.classList.add('btn-primary');
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
