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
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Edit Alumni</h1>
                <div class="">
                    <a href="{{ route('alumni-registrations.index') }}"
                        class="text-secondary-light hover-text-primary hover-underline">Registrations </a>
                    <span class="text-secondary-light">/ Edit {{ $alumniRegistration->firstname }}</span>
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
                    <form action="{{ route('alumni-registrations.update', $alumniRegistration->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Details -->
                        <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2">Personal Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Profile Photo</label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror"
                                    name="profile_photo" accept=".jpg,.jpeg,.png">
                                <small class="text-muted">Max 2MB. Formats: JPG, PNG</small>
                                @if($alumniRegistration->profile_photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $alumniRegistration->profile_photo) }}" 
                                             alt="Current Photo" 
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                    </div>
                                @endif
                                @error('profile_photo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Title <span class="text-danger">*</span></label>
                                <select class="form-select" name="title" required>
                                    <option value="">Select</option>
                                    @foreach ($titles as $title)
                                        <option value="{{ $title }}" {{ old('title', $alumniRegistration->title) == $title ? 'selected' : '' }}>
                                            {{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstname" value="{{ old('firstname', $alumniRegistration->firstname) }}"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Middle Name</label>
                                <input type="text" class="form-control" name="middlename"
                                    value="{{ old('middlename', $alumniRegistration->middlename) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lastname" value="{{ old('lastname', $alumniRegistration->lastname) }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_of_birth"
                                    value="{{ old('date_of_birth', $alumniRegistration->date_of_birth?->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Contact Number <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="contact_number"
                                    value="{{ old('contact_number', $alumniRegistration->contact_number) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">WhatsApp Number</label>
                                <input type="tel" class="form-control" name="whatsapp_number"
                                    value="{{ old('whatsapp_number', $alumniRegistration->whatsapp_number) }}">
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
                                            {{ old('degree_completed', $alumniRegistration->degree_completed) == $degree ? 'selected' : '' }}>{{ $degree }}
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
                                            {{ old('department', $alumniRegistration->department) == $dept ? 'selected' : '' }}>{{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Year of Passing</label>
                                <input type="number" class="form-control" name="year_of_passing"
                                    value="{{ old('year_of_passing', $alumniRegistration->year_of_passing) }}" min="1950" max="{{ date('Y') }}">
                            </div>
                        </div>

                        <!-- Account Details -->
                        <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2">Account Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Email / Login ID <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $alumniRegistration->email) }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-medium mb-0">Residence Country <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="saarcFilter"
                                            onchange="toggleSaarcCountries()"
                                            {{ in_array($alumniRegistration->residence_country, $saarcCountries) ? 'checked' : '' }}>
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
                                            {{ old('residence_country', $alumniRegistration->residence_country) == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" id="countryCount">Showing all countries</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                                <small class="text-muted">Min 8 characters</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
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
                                                {{ old('registration_type_id', $alumniRegistration->registration_type_id) == $type->id ? 'checked' : '' }}
                                                onchange="updateAmount()" required>
                                            <label class="form-check-label" for="type_{{ $type->id }}">
                                                {{ $type->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hidden Amount Field (Auto-calculated) -->
                            <input type="hidden" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', $alumniRegistration->amount_paid) }}">

                            <!-- Documentary Proof Upload -->
                            <div class="col-md-12">
                                <label class="form-label small fw-medium">Update Documentary Proof</label>
                                <input type="file" class="form-control" name="documentary_proof"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Accepted formats: PDF, JPG, PNG (Max 2MB)</small>
                                @if($alumniRegistration->documentary_proof)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $alumniRegistration->documentary_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="ri-eye-line"></i> View Current Document
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Registration Charge Banner -->
                            <div class="col-md-12 mt-3">
                                <div class="alert alert-info bg-info text-white border-0 py-3 px-4 mb-0"
                                    style="background-color: #2ba5b5 !important;">
                                    <h5 class="mb-0 fw-bold">
                                        Registration Charge: <span id="chargeDisplay">INR {{ number_format($alumniRegistration->amount_paid, 2) }}</span>
                                    </h5>
                                </div>
                            </div>

                            <!-- Transaction Date -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label small fw-medium">Transaction Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="payment_transaction_date"
                                    value="{{ old('payment_transaction_date', $alumniRegistration->payment_transaction_date?->format('Y-m-d')) }}" required>
                            </div>

                            <!-- Transaction ID -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label small fw-medium">Transaction ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="payment_transaction_id"
                                    value="{{ old('payment_transaction_id', $alumniRegistration->payment_transaction_id) }}" placeholder="e.g., UTR123456789"
                                    required>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label small fw-medium">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="pending" {{ old('status', $alumniRegistration->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="payment_pending" {{ old('status', $alumniRegistration->status) == 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                                    <option value="approved" {{ old('status', $alumniRegistration->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $alumniRegistration->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="payment_failed" {{ old('status', $alumniRegistration->status) == 'payment_failed' ? 'selected' : '' }}>Payment Failed</option>
                                    <option value="refunded" {{ old('status', $alumniRegistration->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>

                            <!-- Additional Notes -->
                            <div class="col-md-12 mt-3">
                                <label class="form-label small fw-medium">Admin Comment / Notes (Optional)</label>
                                <textarea class="form-control" name="comment" rows="2">{{ old('comment', $alumniRegistration->comment) }}</textarea>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('alumni-registrations.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Alumni</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Card -->
    </div>
@endsection

@push('scripts')
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