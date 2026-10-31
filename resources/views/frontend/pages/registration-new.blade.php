@extends('frontend.layout.master')
@section('title', 'New Registration | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">New Registration</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">New Registration</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="alumni-registration-page">
        <div class="container-fluid">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="alumni-registration-form" method="POST" action="{{ route('alumni.register.store') }}"
                            class="alumni-registration-form" enctype="multipart/form-data">
                            @csrf

                            <!-- Form Title -->
                            <div class="form-group">
                                <h4 class="title">Alumni Registration Form</h4>
                            </div>

                            <!-- Title -->
                            <div class="rbt-modern-select bg-transparent height-45 mb--20">
                                <select class="w-100" name="title" required>
                                    <option value="">Select Title *</option>
                                    @foreach (['Dr.', 'Prof.', 'Mr.', 'Mrs.', 'Ms.'] as $t)
                                        <option value="{{ $t }}" {{ old('title') == $t ? 'selected' : '' }}>
                                            {{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="firstname" value="{{ old('firstname') }}" required>
                                        <label>First Name *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="middlename" value="{{ old('middlename') }}">
                                        <label>Middle Name</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="lastname" value="{{ old('lastname') }}" required>
                                        <label>Last Name *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="form-group">
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                <label>Date of Birth *</label>
                                <span class="focus-border"></span>
                            </div>

                            <!-- Contact Numbers -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            
                                            <input type="tel" name="contact_number" id="contact_number"
                                                value="{{ old('contact_number') }}" class="form-control" required>
                                        </div>
                                        <label>Contact Number *</label>
                                        <small class="text-muted">Please remember this number and <a href="#">Click
                                                here to login</a>.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="sameWhatsApp"
                                                onchange="toggleWhatsApp()">
                                            <label class="form-check-label" for="sameWhatsApp">
                                                Tick the checkbox if your contact number is same as your WhatsApp contact
                                                number
                                            </label>
                                        </div>
                                        <div class="input-group">
                                           
                                            <input type="tel" name="whatsapp_number" id="whatsapp_number"
                                                value="{{ old('whatsapp_number') }}" class="form-control" placeholder="WhatsApp Enabled Contact Number">
                                        </div>
                                       
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="number" name="year_of_passing" value="{{ old('year_of_passing') }}"
                                            min="1950" max="{{ date('Y') }}">
                                        <label>Select Year of passing latest degree from PGIMER</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="number" name="year_of_joining_faculty"
                                            value="{{ old('year_of_joining_faculty') }}" min="1950"
                                            max="{{ date('Y') }}">
                                        <label>Select year of joining PGIMER as faculty/senior resident</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Degree & Department -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="degree_completed" required>
                                            <option value="">Select any degree completed from PGIMER *</option>
                                            @foreach (['MBBS', 'MD', 'MS', 'DM', 'MCh', 'PhD', 'Diploma', 'BSc', 'MSc', 'Fellowship'] as $d)
                                                <option value="{{ $d }}"
                                                    {{ old('degree_completed') == $d ? 'selected' : '' }}>
                                                    {{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="department" required>
                                            <option value="">Select department you were related to at PGIMER *
                                            </option>
                                            @foreach (['Surgical Gastroenterology', 'Medical Gastroenterology', 'Cardiology', 'Neurology', 'Orthopaedics', 'Oncology', 'Pediatrics', 'Radiology', 'General Medicine', 'Other'] as $dept)
                                                <option value="{{ $dept }}"
                                                    {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                           <!-- Email & Country -->
<div class="row">
    <div class="col-lg-6 mt--20">
        <div class="form-group">
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Email ID *</label>
            <span class="focus-border"></span>
            <small class="text-muted">Please remember this email and <a href="#">Click here to login</a>.</small>
        </div>
    </div>
    <div class="col-lg-6 mt--20">
        <label class="mb-1 d-block fw-bold">Residence Country *</label>
        <div class="rbt-modern-select bg-transparent height-45 w-100">
            <!-- 'selectpicker' class aur 'data-live-search' bootstrap-select ke liye zaroori hain -->
            <select class="w-100 selectpicker" data-live-search="true" title="Select Country *" name="residence_country" id="residence_country" required>
                @foreach ($countries as $country)
                    <option value="{{ $country }}" data-is-saarc="{{ in_array($country, $saarcCountries) ? '1' : '0' }}" {{ old('residence_country') == $country ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="saarcFilter" onchange="toggleSaarcCountries()">
            <label class="form-check-label small" for="saarcFilter">Show SAARC Countries Only</label>
        </div>
    </div>
</div>

                            <!-- Password -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="password" name="password" minlength="12" required>
                                        <label>Create Password *</label>
                                        <span class="focus-border"></span>
                                        <small class="text-muted">Use a strong password: at least 12 characters with
                                            uppercase, lowercase, numbers, and symbols. Avoid common words or patterns.
                                            <span class="text-danger">Password must be at least 12
                                                characters</span></small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" minlength="12" required>
                                        <label>Confirm Password *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Practice Information -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="practice_state" value="{{ old('practice_state') }}">
                                        <label>The state that you practice</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="practice_specialty"
                                            value="{{ old('practice_specialty') }}">
                                        <label>Current practice specialty</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- Registration Type -->
                            <div class=" mt--20">
                                <label for="registration_type_id" class="static-label fw-bold">
                                    Registration Type <span class="text-danger">*</span>
                                </label>

                                <div class="rbt-modern-select bg-transparent height-45 mt-3">
                                    <select name="registration_type_id" id="registration_type_id"
                                        class="w-100 reg-type-select" required>
                                        <option value="">Select Registration Type *</option>
                                        @foreach ($registrationTypes as $type)
                                            <option value="{{ $type->id }}" data-amount="{{ $type->amount }}"
                                                {{ old('registration_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-2">
                                    <a href="javascript:void(0)" id="eligibilityLink" onclick="openEligibilityModal();"
                                        style="display: none; color: #0d6efd; text-decoration: underline; font-size: 13px;">
                                        Kindly check eligibility to attend summit
                                    </a>
                                </div>

                                <div id="chargeBox"
                                    style="display: none; margin-top: 15px; padding: 15px;
                background: #f0f9ff; border-left: 4px solid #2ba5b5; border-radius: 4px;">
                                    <strong style="font-size: 18px;">Registration Charge: </strong>
                                    <span id="chargeDisplay"
                                        style="font-size: 20px; font-weight: bold; color: #2ba5b5;">INR 0</span>
                                </div>

                                <input type="hidden" name="amount_paid" id="amount_paid"
                                    value="{{ old('amount_paid') }}">
                            </div>

                            <!-- Documentary Proof -->
                            <div class="form-group">
                                <label class="static-label">Upload documentary proof for your association as alumnus with
                                    PGI</label>
                                <input type="file" name="documentary_proof" accept=".pdf,.jpg,.jpeg,.png" required
                                    class="form-control">
                                <small class="text-muted">Accepted formats: PDF, JPG, PNG (Max 2MB)</small>
                            </div>

                            <!-- Donation/Contribution -->
                            <div class=" mt--20">
                                <label for="donation_amount" class="static-label fw-bold">
                                    Please support the PGI Alumni Society well-being through meaningful and valuable
                                    contributions
                                </label>

                                <div class="rbt-modern-select bg-transparent height-45 mt-3">
                                    <select class="w-100" name="donation_amount" id="donation_amount">
                                        <option value="0" {{ old('donation_amount', '0') == '0' ? 'selected' : '' }}>
                                            Not interested at this moment
                                        </option>
                                        <option value="5000" {{ old('donation_amount') == '5000' ? 'selected' : '' }}>
                                            INR 5,000.00</option>
                                        <option value="10000" {{ old('donation_amount') == '10000' ? 'selected' : '' }}>
                                            INR 10,000.00</option>
                                        <option value="50000" {{ old('donation_amount') == '50000' ? 'selected' : '' }}>
                                            INR 50,000.00</option>
                                        <option value="100000" {{ old('donation_amount') == '100000' ? 'selected' : '' }}>
                                            INR 100,000.00</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">

                            <div class="cf-turnstile" data-sitekey="{{ env('CLOUDFLARE_TURNSTILE_SITE_KEY') }}"></div>
                            @error('cf-turnstile-response')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                            <!-- Agreement -->
                            <div class="form-group mt--20">
                                <p class="rbt-checkbox-wrapper mb--5">
                                        <input id="rbt-checkbox-1" name="agreed_to_rules" value="1" required type="checkbox" {{ old('agreed_to_rules') ? 'checked' : '' }}>
                                        <label for="rbt-checkbox-1">I agree that all the above information is correct to the best of my knowledge</label>
                                    </p>
                                {{-- <label class="checkbox-label">
                                    <input type="checkbox" name="agreed_to_rules" value="1" required
                                         >
                                    I agree that all the above information is correct to the best of my knowledge
                                </label> --}}
                            </div>

                            <!-- Submit -->
                            <div class="form-submit-group">
                                <button name="submit" type="submit" id="submit"
                                    class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Submit</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>

                            <!-- Help Text -->
                            <div class="alert alert-danger mt-4">
                                <h5>For any technical assistance regarding registration (Please Call on <a
                                        href="tel:9463654426">9463654426</a>) and (WhatsApp on <a
                                        href="https://wa.me/6280606365">6280606365</a>)</h5>
                            </div>

                            <!-- Donation Info -->
                            <div class="alert alert-success mt-3">
                                <p>PGI OFFERS DISCOUNTED OR FREE TREATMENT TO FINANCIALLY CHALLENGED PATIENTS THROUGH THE
                                    "POOR PATIENTS FUND" THAT IS FUNDED BY DONORS LIKE YOU.</p>
                                <p>ANY AMOUNT WOULD CONTRIBUTE TO A LIFE SAVING MEANS FOR THESE DESTITUTE PATIENTS.</p>
                                <p><a href="https://pgimer.edu.in/PGIMER_PORTAL/PGIMERPORTAL/GlobalPages/JSP/Page_Data.jsp?dep_id=5676" target="_blank" class="text-primary">PLEASE CLICK HERE TO DONATE.</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Eligibility Modal -->
    <div class="modal fade" id="eligibilityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eligibility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4>2nd PGI Global Alumni Summit</h4>
                        <p>18th - 20th December 2026</p>
                    </div>

                    <ul class="list-unstyled">
                        <li class="mb-3">• Those who have Completed Postgraduate Medical Course/Doctorate from PGIMER
                            (MD, MS, PhD, Fellowships, DM, MCH, MHA, MDS)</li>
                        <li class="mb-3">• Faculty of PGIMER (Past and Present at least 3 years regular service at
                            PGIMER, Chandigarh)</li>
                        <li class="mb-3">• Those who have worked for at least 3 years in an academic medical job/Senior
                            Residency training at PGIMER.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<!-- Agar aapke master layout me bootstrap-select ka JS/CSS nahi hai, toh ye 2 lines add kar dein -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script> -->

<script>
// 1. Scrolling / Modal Backdrop Stuck Fix (Sabse pehle run karein)
function fixScrolling() {
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(b => b.remove());
}

// 2. WhatsApp checkbox functionality
function toggleWhatsApp() {
    const checkbox = document.getElementById('sameWhatsApp');
    const contactNumber = document.getElementById('contact_number');
    const whatsappNumber = document.getElementById('whatsapp_number');
    
    if (checkbox && contactNumber && whatsappNumber) {
        if (checkbox.checked) {
            whatsappNumber.value = contactNumber.value;
            whatsappNumber.readOnly = true;
            whatsappNumber.style.backgroundColor = '#e9ecef';
        } else {
            whatsappNumber.value = '';
            whatsappNumber.readOnly = false;
            whatsappNumber.style.backgroundColor = '';
        }
    }
}

// 3. SAARC Filter (Bootstrap Select Compatible)
function toggleSaarcCountries() {
    const checkbox = document.getElementById('saarcFilter');
    const select = document.getElementById('residence_country');
    if (!select) return;

    const isSaarcFilter = checkbox.checked;
    const options = select.querySelectorAll('option');

    // Original options ko hide/disable karein
    options.forEach(option => {
        if (option.value === '') return;
        const isSaarc = option.getAttribute('data-is-saarc') === '1';

        if (isSaarcFilter && !isSaarc) {
            option.style.display = 'none';
            option.disabled = true;
        } else {
            option.style.display = '';
            option.disabled = false;
        }
    });

    // Agar Bootstrap Select active hai, toh usko refresh karein
    if (typeof $ !== 'undefined' && $(select).hasClass('selectpicker')) {
        $(select).selectpicker('refresh');
        
        // Bootstrap Select ke generated dropdown items ko bhi manually hide karein
        setTimeout(() => {
            const dropdownItems = select.parentElement.querySelectorAll('.dropdown-menu .dropdown-item');
            dropdownItems.forEach(item => {
                const index = item.getAttribute('data-original-index');
                if (index !== null) {
                    const opt = select.options[index];
                    if (opt && opt.disabled) {
                        item.style.display = 'none';
                    } else {
                        item.style.display = '';
                    }
                }
            });
        }, 50);
    }
}

// 4. Registration Type Amount Update
document.addEventListener('DOMContentLoaded', function() {
    // Scrolling fix on page load
    fixScrolling();

    // WhatsApp sync
    const contactInput = document.getElementById('contact_number');
    if (contactInput) {
        contactInput.addEventListener('input', function() {
            const checkbox = document.getElementById('sameWhatsApp');
            if (checkbox && checkbox.checked) {
                const whatsappInput = document.getElementById('whatsapp_number');
                if (whatsappInput) whatsappInput.value = this.value;
            }
        });
    }

    // Registration type dropdown logic
    const registrationSelect = document.getElementById('registration_type_id');
    if (registrationSelect) {
        registrationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const selectedAmount = selectedOption ? parseFloat(selectedOption.dataset.amount) : NaN;
            const parsedAmount = Number.isFinite(selectedAmount) ? selectedAmount : 0;
            
            document.getElementById('amount_paid').value = this.value ? parsedAmount : '';
            document.getElementById('chargeDisplay').textContent = 'INR ' + parsedAmount.toLocaleString('en-IN');
            document.getElementById('chargeBox').style.display = this.value ? 'block' : 'none';

            const eligibilityLink = document.getElementById('eligibilityLink');
            if (eligibilityLink) {
                eligibilityLink.style.display = selectedOption.textContent.includes('Global PGI Alumni Summit') ? 'inline-block' : 'none';
            }
        });
        
        // Trigger on load if pre-selected
        registrationSelect.dispatchEvent(new Event('change'));
    }
});

// 5. Eligibility Modal with Scroll Fix
function openEligibilityModal() {
    const modalEl = document.getElementById('eligibilityModal');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        
        // Jab modal band ho, scrolling fix zaroor call karein
        modalEl.addEventListener('hidden.bs.modal', function () {
            fixScrolling();
        }, { once: true });
    }
}
</script>
@endpush