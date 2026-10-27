@extends('backend.layouts.master')

@section('content')
    <div class="dashboard-main-body">

        <!-- SweetAlert Session Messages -->
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const errorList = @json($errors->all()).map(err => `<li>${err}</li>`).join('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error!',
                        html: `<ul class="text-start mb-0">${errorList}</ul>`,
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        @endif

        <!-- Start Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="">
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Add New Alumni</h1>
                <div class="">
                    <a href="{{ route('alumni-registrations.index') }}"
                        class="text-secondary-light hover-text-primary hover-underline">Registrations </a>
                    <span class="text-secondary-light">/ Add New</span>
                </div>
            </div>
            <a href="{{ route('alumni-registrations.index') }}" class="btn btn-light d-flex align-items-center gap-2">
                <i class="ri-arrow-left-line"></i> Back to List
            </a>
        </div>
        <!-- End Page Header -->

        <!-- Start Form Card -->
        <div class="mt-24">
            <div class="card h-100">
                <div class="card-body p-24">
                    <form action="{{ route('alumni-registrations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Details -->
                        <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2">Personal Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Profile Photo</label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror"
                                    name="profile_photo" accept=".jpg,.jpeg,.png">
                                <small class="text-muted">Max 2MB. Formats: JPG, PNG</small>
                                @error('profile_photo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Title <span class="text-danger">*</span></label>
                                <select class="form-select" name="title" required>
                                    <option value="">Select</option>
                                    @foreach ($titles as $title)
                                        <option value="{{ $title }}" {{ old('title') == $title ? 'selected' : '' }}>
                                            {{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Middle Name</label>
                                <input type="text" class="form-control" name="middlename"
                                    value="{{ old('middlename') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_of_birth"
                                    value="{{ old('date_of_birth') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Contact Number <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="contact_number"
                                    value="{{ old('contact_number') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">WhatsApp Number</label>
                                <input type="tel" class="form-control" name="whatsapp_number"
                                    value="{{ old('whatsapp_number') }}">
                            </div>
                        </div>

                        <!-- PGIMER Details -->
                        <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2">PGIMER Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Degree Completed <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="degree_completed" required>
                                    <option value="">Select Degree</option>
                                    @foreach ($degrees as $degree)
                                        <option value="{{ $degree }}"
                                            {{ old('degree_completed') == $degree ? 'selected' : '' }}>{{ $degree }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Department <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="department" required>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept }}"
                                            {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Year of Passing</label>
                                <input type="number" class="form-control" name="year_of_passing"
                                    value="{{ old('year_of_passing') }}" min="1950" max="{{ date('Y') }}">
                            </div>
                        </div>

                        <!-- Account Details -->
                        <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2">Account Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Email / Login ID <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-medium mb-0">Residence Country <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="saarcFilter"
                                            onchange="toggleSaarcCountries()">
                                        <label class="form-check-label small text-primary fw-medium" for="saarcFilter">
                                            <i class="ri-flag-line"></i> SAARC Countries?
                                        </label>
                                    </div>
                                </div>
                                <select class="form-select" name="residence_country" id="residence_country" required>
                                    <option value="">Select Country</option>
                                    @foreach ($allCountries as $country)
                                        <option value="{{ $country }}"
                                            data-is-saarc="{{ in_array($country, $saarcCountries) ? '1' : '0' }}"
                                            {{ old('residence_country') == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" id="countryCount">Showing all countries</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <!-- Registration & Payment Details -->
                        <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2">Registration & Payment Details</h6>
                        <div class="row g-3 mb-4">
                            <!-- Membership Type Radio Buttons -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label small fw-medium mb-2">Membership Type <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2">
                                    @foreach ($registrationTypes as $type)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="registration_type_id"
                                                id="type_{{ $type->id }}" value="{{ $type->id }}"
                                                data-amount="{{ $type->amount }}"
                                                {{ old('registration_type_id') == $type->id ? 'checked' : '' }}
                                                onchange="updateAmount()" required>
                                            <label class="form-check-label" for="type_{{ $type->id }}">
                                                {{ $type->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hidden Amount Field (Auto-calculated) -->
                            <input type="hidden" name="amount_paid" id="amount_paid" value="{{ old('amount_paid') }}">

                            <!-- Documentary Proof Upload -->
                            <div class="col-md-12">
                                <label class="form-label small fw-medium">Upload documentary proof for your association as
                                    alumnus with PG</label>
                                <input type="file" class="form-control" name="documentary_proof"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Accepted formats: PDF, JPG, PNG (Max 2MB)</small>
                            </div>

                            <!-- Registration Charge Banner -->
                            <div class="col-md-12 mt-3">
                                <div class="alert alert-info bg-info text-white border-0 py-3 px-4 mb-0"
                                    style="background-color: #2ba5b5 !important;">
                                    <h5 class="mb-0 fw-bold">
                                        Registration Charge: <span id="chargeDisplay">INR 0</span>
                                    </h5>
                                </div>
                            </div>

                            <!-- ✅ Transaction Date (Wapas Add Kiya) -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label small fw-medium">Transaction Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="payment_transaction_date"
                                    value="{{ old('payment_transaction_date') }}" required>
                            </div>

                            <!-- ✅ Transaction ID (Wapas Add Kiya) -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label small fw-medium">Transaction ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="payment_transaction_id"
                                    value="{{ old('payment_transaction_id') }}" placeholder="e.g., UTR123456789"
                                    required>
                            </div>

                            <!-- Additional Notes -->
                            <div class="col-md-12 mt-3">
                                <label class="form-label small fw-medium">Admin Comment / Notes (Optional)</label>
                                <textarea class="form-control" name="comment" rows="2">{{ old('comment') }}</textarea>
                            </div>


                        </div>

                        <div class="mb-4">

                            <div class="cf-turnstile" data-sitekey="{{ env('CLOUDFLARE_TURNSTILE_SITE_KEY') }}"></div>
                            @error('cf-turnstile-response')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('alumni-registrations.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Alumni</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Card -->
    </div>
@endsection

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        // 1. Amount Update Logic
        function updateAmount() {
            const selectedRadio = document.querySelector('input[name="registration_type_id"]:checked');
            const amountInput = document.getElementById('amount_paid');
            const chargeDisplay = document.getElementById('chargeDisplay');

            if (selectedRadio) {
                const amount = selectedRadio.getAttribute('data-amount');
                amountInput.value = amount;
                chargeDisplay.textContent = `INR ${parseFloat(amount).toLocaleString('en-IN')}`;
            } else {
                amountInput.value = '';
                chargeDisplay.textContent = 'INR 0';
            }
        }

        // 2. SAARC Country Filter Logic
        function toggleSaarcCountries() {
            const checkbox = document.getElementById('saarcFilter');
            const select = document.getElementById('residence_country');
            const options = select.querySelectorAll('option');
            const countLabel = document.getElementById('countryCount');
            const isSaarcFilter = checkbox.checked;

            let visibleCount = 0;

            options.forEach(option => {
                if (option.value === '') return;
                const isSaarc = option.getAttribute('data-is-saarc') === '1';

                if (isSaarcFilter) {
                    if (isSaarc) {
                        option.style.display = '';
                        visibleCount++;
                    } else {
                        option.style.display = 'none';
                        if (option.selected) select.value = '';
                    }
                } else {
                    option.style.display = '';
                    visibleCount++;
                }
            });

            if (isSaarcFilter) {
                countLabel.textContent = `Showing ${visibleCount} SAARC countries only`;
                countLabel.classList.add('text-primary', 'fw-medium');
            } else {
                countLabel.textContent = 'Showing all countries';
                countLabel.classList.remove('text-primary', 'fw-medium');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateAmount();
            const checkbox = document.getElementById('saarcFilter');
            if (checkbox && checkbox.checked) {
                toggleSaarcCountries();
            }
        });
    </script>
@endpush
