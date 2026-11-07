@extends('frontend.layout.master')
@section('title', 'PG Students Registration | PGI Alumni')
@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.3/build/css/intlTelInput.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap');

        .pgi-reg, .pgi-modal {
            --ink: #14263a; --teal: #1b1973; --teal-soft: #e4f1f0; --gold: #c8963e; --gold-soft: #fbf3e2;
            --paper: #f4f6f8; --line: #dde3ea; --muted: #64748b; --danger: #b3261e;
            font-family: 'DM Sans', sans-serif; font-size: 16px; line-height: 1.55; color: var(--ink);
        }
        .pgi-reg { background: var(--paper); padding: 48px 0 64px; }
        .pgi-reg h4, .pgi-reg h5, .pgi-reg p, .pgi-reg label, .pgi-reg span, .pgi-reg small, .pgi-reg button, .pgi-reg li,
        .pgi-modal h5, .pgi-modal li, .pgi-modal button { font-family: 'DM Sans', sans-serif; }
        .pgi-reg .shell { max-width: 920px; margin: 0 auto; }

        /* Intro */
        .reg-intro { text-align: center; margin-bottom: 28px; }
        .pgi-reg .reg-intro h4 { font-family: 'Fraunces', serif; font-size: 32px; font-weight: 700; margin-bottom: 6px; }
        .reg-intro p { color: var(--muted); font-size: 16px; margin: 0; }

        .invite { display: flex; gap: 16px; align-items: flex-start; background: var(--gold-soft); border: 1px solid #ecd9ab; border-left: 5px solid var(--gold); border-radius: 14px; padding: 20px 22px; margin-bottom: 24px; }
        .invite .ico { flex: none; width: 46px; height: 46px; border-radius: 50%; background: var(--gold); color: #fff; display: grid; place-items: center; font-size: 22px; }
        .pgi-reg .invite h5 { font-family: 'Fraunces', serif; font-size: 19px; font-weight: 700; margin: 0 0 4px; }
        .pgi-reg .invite p { margin: 0; font-size: 15px; color: #5b4a22; }

        /* Alerts */
        .pgi-reg .alert { border-radius: 12px; font-size: 15px; }

        /* Section cards */
        .sec { background: #fff; border: 1px solid var(--line); border-radius: 14px; margin-bottom: 20px; overflow: visible; box-shadow: 0 1px 2px rgba(20,38,58,.04); }
        .sec-head { display: flex; align-items: center; gap: 14px; padding: 16px 24px; border-bottom: 1px solid var(--line); background: #fafbfc; border-radius: 14px 14px 0 0; }
        .sec-num { flex: none; width: 32px; height: 32px; border-radius: 50%; background: var(--teal); color: #fff; font-weight: 700; font-size: 15px; display: grid; place-items: center; }
        .pgi-reg .sec-head h5 { margin: 0; font-size: 18px; font-weight: 700; line-height: 1.35; }
        .pgi-reg .sec-head small { display: block; margin-top: 3px; color: var(--muted); font-size: 14px; font-weight: 400; line-height: 1.4; }
        .pgi-reg .sec { position: relative; }
        .pgi-reg .dropdown-menu, .pgi-reg .nice-select .list { z-index: 1050; }
        .sec-body { padding: 24px; }

        /* Fields */
        .pgi-reg .fl { display: block; font-size: 15px; font-weight: 600; margin-bottom: 7px; color: var(--ink); }
        .pgi-reg .fl .req { color: var(--danger); margin-left: 2px; }
        .pgi-reg .fl .opt { color: var(--muted); font-weight: 400; font-size: 13px; margin-left: 4px; }
        .pgi-reg .fc, .pgi-reg .input-group-text {
            width: 100%; height: 48px; padding: 0 14px; font-size: 16px; color: var(--ink);
            background: #fff; border: 1.5px solid var(--line); border-radius: 10px; box-shadow: none; outline: 0;
            transition: border-color .15s, box-shadow .15s;
        }
        .pgi-reg .fc::placeholder { color: #9aa7b6; }
        .pgi-reg .fc:focus { border-color: var(--teal); box-shadow: 0 0 0 4px rgba(15,107,107,.12); }
        .pgi-reg .fc[readonly] { background: #eef1f5; }
        .pgi-reg .input-group { display: flex; flex-wrap: nowrap; }
        .pgi-reg .input-group .input-group-text { width: auto; flex: none; background: var(--paper); border-right: 0; border-radius: 10px 0 0 10px; font-weight: 600; font-size: 15px; display: flex; align-items: center; }
        .pgi-reg .input-group .fc { border-radius: 0 10px 10px 0; }
        .pgi-reg .hint { display: block; margin-top: 6px; font-size: 13.5px; color: var(--muted); line-height: 1.45; }
        .pgi-reg .hint a { color: var(--teal); font-weight: 600; }
        .pgi-reg .fg { margin-bottom: 20px; }
        .pgi-reg .rbt-modern-select, .pgi-reg .bootstrap-select { width: 100% !important; }
        .pgi-reg .rbt-modern-select select, .pgi-reg .bootstrap-select > .dropdown-toggle { border: 1.5px solid var(--line) !important; border-radius: 10px !important; font-size: 16px; min-height: 48px; background: #fff !important; }
        .pgi-reg .bootstrap-select > .dropdown-toggle { padding: 0 14px; }

        /* Checkbox lines */
        .chk { display: flex; gap: 12px; align-items: flex-start; }
        .chk input { flex: none; width: 20px; height: 20px; margin-top: 3px; accent-color: var(--teal); cursor: pointer; }
        .pgi-reg .chk label { font-size: 15px; font-weight: 500; margin: 0; cursor: pointer; }
        .chk-box { background: var(--paper); border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; margin-bottom: 12px; }

        /* Charge box */
        #chargeBox { background: var(--teal-soft) !important; border: 1px solid #b9dad8 !important; border-left: 5px solid var(--teal) !important; border-radius: 12px !important; padding: 16px 20px !important; margin-top: 16px !important; }
        .charge-label { font-size: 15px; font-weight: 600; color: var(--muted); display: block; }
        .charge-amt { font-family: 'Fraunces', serif; font-size: 30px; font-weight: 700; color: var(--teal); line-height: 1.2; }
        .charge-note { display: block; margin-top: 6px; font-size: 14.5px; font-weight: 600; color: #17693a; }

        /* Submit */
        .btn-submit { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 16px 24px; background: var(--teal); color: #fff; border: 0; border-radius: 12px; font-size: 18px; font-weight: 700; cursor: pointer; transition: background .2s, transform .1s; }
        .btn-submit:hover { background: #4a478f; }
        .btn-submit:active { transform: translateY(1px); }
        .pgi-reg :focus-visible, .pgi-modal :focus-visible { outline: 3px solid rgba(15,107,107,.4); outline-offset: 2px; }

        /* Help boxes */
        .help { display: flex; gap: 14px; align-items: flex-start; border-radius: 14px; padding: 18px 22px; margin-top: 20px; font-size: 15px; }
        .help i { font-size: 22px; margin-top: 2px; flex: none; }
        .help.contact { background: #fff; border: 1px solid var(--line); }
        .help.contact i { color: var(--teal); }
        .pgi-reg .help p { margin: 0 0 6px; font-size: 15px; }
        .pgi-reg .help p:last-child { margin: 0; }
        .pgi-reg .help a { color: var(--teal); font-weight: 600; }
        .help.cause { background: #eaf6ee; border: 1px solid #c6e5d1; color: #1c4a2c; }
        .help.cause i { color: #17693a; }

        /* Modal */
        .pgi-modal .modal-content { border: 0; border-radius: 16px; overflow: hidden; }
        .pgi-modal .modal-header { background: var(--ink); border: 0; padding: 18px 24px; }
        .pgi-modal .modal-title { font-family: 'Fraunces', serif; font-size: 22px; color: #fff; }
        .pgi-modal .btn-close { filter: invert(1); }
        .pgi-modal .modal-body { padding: 24px; font-size: 16px; }
        .pgi-modal .modal-body h4 { font-family: 'Fraunces', serif; font-size: 24px; }
        .pgi-modal .btn-light { background: #fff; border: 1px solid var(--line); border-radius: 10px; padding: 9px 20px; font-weight: 600; font-size: 15px; }


        /* Phone input (intl-tel-input) */
        .pgi-reg .iti { display: block; width: 100%; }
        .pgi-reg .iti .fc { padding-right: 14px; }
        .pgi-reg .iti__selected-flag { border-radius: 10px 0 0 10px; padding: 0 10px 0 14px; }
        .pgi-reg .iti__selected-dial-code { font-size: 15px; font-weight: 600; color: var(--ink); }
        .pgi-reg .iti.iti-locked .iti__selected-flag { pointer-events: none; opacity: .7; }
        .iti__country-list { font-family: 'DM Sans', sans-serif; font-size: 15px; border-radius: 10px; border: 1px solid #dde3ea; box-shadow: 0 12px 32px rgba(20,38,58,.16); max-width: 92vw; }
        .iti__country { padding: 9px 12px; }
        .iti--container { z-index: 2000; }

        @media (max-width: 767px) {
            .pgi-reg { padding: 28px 0 44px; }
            .sec-body, .sec-head { padding-left: 16px; padding-right: 16px; }
            .pgi-reg .reg-intro h4 { font-size: 26px; }
            .invite { flex-direction: column; }
        }
        @media (prefers-reduced-motion: reduce) { .pgi-reg *, .pgi-modal * { transition: none !important; } }
    </style>

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">PG Students Registration</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">PG Students Registration</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="pgi-reg alumni-registration-page">
        <div class="container">
            <div class="shell">

                {{-- <div class="reg-intro">
                    <h4>Alumni Registration Form</h4>
                    <p>Fill in your details below. Fields marked <span style="color:#b3261e">*</span> are required.</p>
                </div> --}}

                <div class="invite">
                    <div class="ico"><i class="feather-info"></i></div>
                    <div>
                        <h5>Special invitation for MD, DM, Junior Resident and Senior Resident alumni</h5>
                        <p>We are currently accepting registrations only for <strong>MD, DM, Junior Resident and Senior Resident</strong> degree holders. As a special benefit, your <strong>Alumni Meet (Summit) is absolutely FREE</strong> with your membership.</p>
                    </div>
                </div>

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

                    <!-- 1. Personal -->
                    <div class="sec">
                        <div class="sec-head">
                            <span class="sec-num">1</span>
                            <h5>Personal details<small>Your name and date of birth</small></h5>
                        </div>
                        <div class="sec-body">
                            <div class="row g-3">
                                <div class="col-md-3 fg mb-0">
                                    <label class="fl">Title <span class="req">*</span></label>
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="title" required>
                                            <option value="">Select title *</option>
                                            @foreach (['Dr.', 'Prof.', 'Mr.', 'Mrs.', 'Ms.'] as $t)
                                                <option value="{{ $t }}" {{ old('title') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="fl" for="firstname">First name <span class="req">*</span></label>
                                    <input class="fc" type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="First name" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="fl" for="middlename">Middle name <span class="opt">(optional)</span></label>
                                    <input class="fc" type="text" id="middlename" name="middlename" value="{{ old('middlename') }}" placeholder="Middle name">
                                </div>
                                <div class="col-md-3">
                                    <label class="fl" for="lastname">Last name <span class="req">*</span></label>
                                    <input class="fc" type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" placeholder="Last name" required>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="fl" for="date_of_birth">Date of birth <span class="req">*</span></label>
                                    <input class="fc" type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Contact -->
                    <div class="sec">
                        <div class="sec-head">
                            <span class="sec-num">2</span>
                            <h5>Contact and login details<small>How we will reach you, and your password</small></h5>
                        </div>
                        <div class="sec-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="fl" for="contact_number">Contact number <span class="req">*</span></label>
                                    <input class="fc" type="tel" name="contact_number" id="contact_number"
                                        value="{{ old('contact_number') }}" placeholder="9876543210" required>
                                    <input type="hidden" name="contact_country_code" id="contact_country_code" value="{{ old('contact_country_code', '+91') }}">
                                    <span class="hint">Please remember this number and <a href="#">click here to login</a>.</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="fl" for="whatsapp_number">WhatsApp number</label>
                                    <input class="fc" type="tel" name="whatsapp_number" id="whatsapp_number"
                                        value="{{ old('whatsapp_number') }}" placeholder="WhatsApp enabled number">
                                    <input type="hidden" name="whatsapp_country_code" id="whatsapp_country_code" value="{{ old('whatsapp_country_code', '+91') }}">
                                    <div class="chk mt-2">
                                        <input type="checkbox" id="sameWhatsApp" onchange="toggleWhatsApp()">
                                        <label for="sameWhatsApp">My contact number is the same as my WhatsApp number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fl" for="email">Email ID <span class="req">*</span></label>
                                    <input class="fc" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                    <span class="hint">Please remember this email and <a href="#">click here to login</a>.</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="fl" for="password">Create password <span class="req">*</span></label>
                                    <input class="fc" type="password" id="password" name="password" placeholder="Create a password" required>
                                    <span class="hint">Use uppercase, lowercase, numbers and symbols. Avoid common words or patterns.</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="fl" for="password_confirmation">Confirm password <span class="req">*</span></label>
                                    <input class="fc" type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Academic -->
                    <div class="sec">
                        <div class="sec-head">
                            <span class="sec-num">3</span>
                            <h5>PGIMER and location<small>Your degree, department and country</small></h5>
                        </div>
                        <div class="sec-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="fl">Degree completed <span class="req">*</span></label>
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="degree_completed" required>
                                            <option value="">Select degree *</option>
                                            @foreach (config('alumni_options.degrees') as $d)
                                                <option value="{{ $d }}" {{ old('degree_completed') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fl">Department at PGIMER <span class="req">*</span></label>
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100 selectpicker" name="department" data-live-search="true" required>
                                            <option value="">Select department you were related to at PGIMER *</option>
                                            @foreach (config('alumni_options.departments') as $dept)
                                                <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fl">Residence country <span class="req">*</span></label>
                                    <div class="rbt-modern-select bg-transparent height-45 w-100">
                                        <select class="w-100 selectpicker" data-live-search="true"
                                            title="Select country *" name="residence_country" id="residence_country" required>
                                            @foreach (config('alumni_options.all_countries') as $country)
                                                <option value="{{ $country }}"
                                                    data-is-saarc="{{ in_array($country, $saarcCountries) ? '1' : '0' }}"
                                                    {{ old('residence_country') == $country ? 'selected' : '' }}>
                                                    {{ $country }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="chk mt-2">
                                        <input type="checkbox" id="saarcFilter" onchange="toggleSaarcCountries()">
                                        <label for="saarcFilter">Show SAARC countries only</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Registration & contribution -->
                    <div class="sec">
                        <div class="sec-head">
                            <span class="sec-num">4</span>
                            <h5>Registration and contribution<small>Choose your membership and an optional donation</small></h5>
                        </div>
                        <div class="sec-body">
                            <div class="fg">
                                <label class="fl" for="registration_type_id">Registration type <span class="req">*</span></label>
                                <div class="rbt-modern-select bg-transparent height-45">
                                    <select name="registration_type_id" id="registration_type_id" class="w-100 reg-type-select" required>
                                        <option value="">Select registration type *</option>
                                        @foreach ($registrationTypes as $type)
                                            <option value="{{ $type->id }}" data-amount="{{ $type->amount }}"
                                                {{ old('registration_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="chargeBox" style="display: none;">
                                    <span class="charge-label">Registration charge</span>
                                    <span id="chargeDisplay" class="charge-amt">INR 0</span>
                                </div>

                                <input type="hidden" name="amount_paid" id="amount_paid" value="{{ old('amount_paid') }}">
                            </div>

                            <div class="mb-0">
                                <label class="fl" for="donation_amount">Support the PGI Alumni Society <span class="opt">(optional)</span></label>
                                <div class="rbt-modern-select bg-transparent height-45">
                                    <select class="w-100" name="donation_amount" id="donation_amount">
                                        <option value="0" {{ old('donation_amount', '0') == '0' ? 'selected' : '' }}>Not interested at this moment</option>
                                        @foreach ([1000, 2000, 3000, 4000, 5000] as $amt)
                                            <option value="{{ $amt }}" {{ old('donation_amount') == (string) $amt ? 'selected' : '' }}>
                                                INR {{ number_format($amt, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="hint">Your contribution supports the well-being of the PGI Alumni Society.</span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Verify & submit -->
                    <div class="sec">
                        <div class="sec-head">
                            <span class="sec-num">5</span>
                            <h5>Verify and submit<small>One last step</small></h5>
                        </div>
                        <div class="sec-body">
                            <div class="mb-4">
                                <div class="cf-turnstile" data-sitekey="{{ env('CLOUDFLARE_TURNSTILE_SITE_KEY') }}"></div>
                                @error('cf-turnstile-response')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="chk-box">
                                <div class="chk">
                                    <input id="rbt-checkbox-1" name="agreed_to_rules" value="1" required type="checkbox"
                                        {{ old('agreed_to_rules') ? 'checked' : '' }}>
                                    <label for="rbt-checkbox-1">I agree that all the above information is correct to the best of my knowledge.</label>
                                </div>
                            </div>

                            <button name="submit" type="submit" id="submit" class="btn-submit">
                                Submit registration <i class="feather-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Help -->
                    <div class="help contact">
                        <i class="feather-headphones"></i>
                        <div>
                            <p><strong>Need help with registration?</strong></p>
                            <p>Call <a href="tel:9463654426">9463654426</a> or WhatsApp <a href="https://wa.me/6280606365">6280606365</a>.</p>
                        </div>
                    </div>

                    <div class="help cause">
                        <i class="feather-heart"></i>
                        <div>
                            <p>PGI OFFERS DISCOUNTED OR FREE TREATMENT TO FINANCIALLY CHALLENGED PATIENTS THROUGH THE "POOR PATIENTS FUND" THAT IS FUNDED BY DONORS LIKE YOU.</p>
                            <p>ANY AMOUNT WOULD CONTRIBUTE TO A LIFE SAVING MEANS FOR THESE DESTITUTE PATIENTS.</p>
                            <p><a href="https://pgimer.edu.in/PGIMER_PORTAL/PGIMERPORTAL/GlobalPages/JSP/Page_Data.jsp?dep_id=5676" target="_blank">PLEASE CLICK HERE TO DONATE.</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Eligibility Modal -->
    <div class="modal fade pgi-modal" id="eligibilityModal" tabindex="-1">
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.3/build/js/intlTelInput.min.js"></script>

    <script>
        // 1. Scrolling / Modal Backdrop Stuck Fix
        function fixScrolling() {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(b => b.remove());
        }

        // 2. Phone inputs with country flag + dial code
        let itiContact = null, itiWhatsapp = null;

        function initPhoneInputs() {
            if (typeof window.intlTelInput !== 'function') return;
            const opts = {
                initialCountry: 'in',
                preferredCountries: ['in', 'us', 'gb', 'ae', 'ca', 'au'],
                separateDialCode: true,
                dropdownContainer: document.body,
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.3/build/js/utils.js'
            };
            const c = document.getElementById('contact_number');
            const w = document.getElementById('whatsapp_number');
            if (c) itiContact = window.intlTelInput(c, opts);
            if (w) itiWhatsapp = window.intlTelInput(w, opts);

            // Restore previously chosen codes after a validation error
            [['contact_country_code', itiContact], ['whatsapp_country_code', itiWhatsapp]].forEach(([id, iti]) => {
                const el = document.getElementById(id);
                if (iti && el && el.value) {
                    const match = window.intlTelInputGlobals.getCountryData()
                        .find(x => '+' + x.dialCode === el.value);
                    if (match) iti.setCountry(match.iso2);
                }
            });

            syncDialCodes();
            c.addEventListener('countrychange', function () { syncDialCodes(); syncWhatsApp(); });
            w.addEventListener('countrychange', syncDialCodes);
        }

        function syncDialCodes() {
            if (itiContact) document.getElementById('contact_country_code').value = '+' + itiContact.getSelectedCountryData().dialCode;
            if (itiWhatsapp) document.getElementById('whatsapp_country_code').value = '+' + itiWhatsapp.getSelectedCountryData().dialCode;
        }

        function syncWhatsApp() {
            const checkbox = document.getElementById('sameWhatsApp');
            if (!checkbox || !checkbox.checked) return;
            const c = document.getElementById('contact_number');
            const w = document.getElementById('whatsapp_number');
            w.value = c.value;
            if (itiContact && itiWhatsapp) itiWhatsapp.setCountry(itiContact.getSelectedCountryData().iso2);
            syncDialCodes();
        }

        // WhatsApp checkbox functionality
        function toggleWhatsApp() {
            const checkbox = document.getElementById('sameWhatsApp');
            const contactNumber = document.getElementById('contact_number');
            const whatsappNumber = document.getElementById('whatsapp_number');

            if (checkbox && contactNumber && whatsappNumber) {
                const wrap = whatsappNumber.closest('.iti');
                if (checkbox.checked) {
                    syncWhatsApp();
                    whatsappNumber.readOnly = true;
                    if (wrap) wrap.classList.add('iti-locked');
                } else {
                    whatsappNumber.value = '';
                    whatsappNumber.readOnly = false;
                    if (wrap) wrap.classList.remove('iti-locked');
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

            if (typeof $ !== 'undefined' && $(select).hasClass('selectpicker')) {
                $(select).selectpicker('refresh');

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
            fixScrolling();
            initPhoneInputs();

            // WhatsApp sync
            const contactInput = document.getElementById('contact_number');
            if (contactInput) {
                contactInput.addEventListener('input', syncWhatsApp);
                // Make sure the dial codes are current when the form is submitted
                const regForm = document.getElementById('alumni-registration-form');
                if (regForm) regForm.addEventListener('submit', syncDialCodes);
            }

            // Registration type dropdown logic
            const registrationSelect = document.getElementById('registration_type_id');
            if (registrationSelect) {
                registrationSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const selectedAmount = selectedOption ? parseFloat(selectedOption.dataset.amount) : NaN;
                    const parsedAmount = Number.isFinite(selectedAmount) ? selectedAmount : 0;

                    document.getElementById('amount_paid').value = this.value ? parsedAmount : '';
                    document.getElementById('chargeBox').style.display = this.value ? 'block' : 'none';

                    const chargeDisplay = document.getElementById('chargeDisplay');

                    if (this.value) {
                        chargeDisplay.innerHTML = 'INR ' + parsedAmount.toLocaleString('en-IN') +
                            '<span class="charge-note">🎉 Global Alumni Medical Conclave (INR 12,000) is FREE! You only need to pay the membership fee.</span>';
                    } else {
                        chargeDisplay.textContent = 'INR 0';
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

                modalEl.addEventListener('hidden.bs.modal', function() {
                    fixScrolling();
                }, {
                    once: true
                });
            }
        }
    </script>
@endpush