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
                            <li><div class="icon-right"><i class="feather-chevron-right"></i></div></li>
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
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 class="rounded-circle mb-3 mx-auto d-block" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <!-- ✅ mx-auto aur d-flex add kiya hai center karne ke liye -->
                            <div class="d-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto bg-primary text-white" 
                                 style="width: 120px; height: 120px; font-size: 40px;">
                                {{ strtoupper(substr($user->firstname, 0, 1)) }}
                            </div>
                        @endif

                        <h5 class="fw-bold mb-1">{{ strtoupper($user->firstname . ' ' . $user->lastname) }}</h5>
                        <p class="text-muted small mb-2">Mobile: +91{{ $user->contact_number }}</p>
                        <p class="text-muted small mb-3">Email: {{ $user->email }}</p>
                        
                        <div class="d-grid gap-2">
                            <a href="hotels-accommodations" class="btn btn-sm btn-primary">Click Here For Accommodations</a>
                            <button class="btn btn-sm btn-warning">Reset Password</button>
                            <form action="{{ route('alumni-logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger w-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-8">
                    
                    <!-- Personal Details Table -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <table class="table table-borderless table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold" style="width: 40%;">Email</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="fw-semibold">Mobile</td>
                                        <td>+91{{ $user->contact_number }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">WhatsApp Contact Number</td>
                                        <td colspan="3">+91{{ $user->whatsapp_number ?? $user->contact_number }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Year of passing latest degree from PGIMER</td>
                                        <td colspan="3">{{ $user->year_of_passing ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Year of joining PGIMER as faculty</td>
                                        <td colspan="3">{{ $user->year_of_joining_faculty ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Country</td>
                                        <td colspan="3">{{ $user->residence_country ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Any degree completed from PGIMER</td>
                                        <td colspan="3">{{ $user->degree_completed ?? 'NA' }}</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="fw-semibold">Department you were related to at PGIMER</td>
                                        <td colspan="3">{{ $user->department ?? 'NA' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center bg-light">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#summitRegistrationModal">
                                Register for Global PGI Alumni Summit 2026
                            </button>
                        </div>
                    </div>

                    <!-- Provisional Receipt Section -->
                    @if($user->payments->isNotEmpty() || $user->amount_paid > 0)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Provisional Receipt</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Receipt ID</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Fee</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $user->membership_id ?? 'PCAAS' . $user->id }}</td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>Main</td>
                                        <td>INR {{ number_format($user->amount_paid, 2) }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Check Receipt</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Donation Section -->
                    <div class="card shadow-sm mb-4 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Please support the PGI Alumni Society well-being through meaningful and valuable contributions</h6>
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="5000" id="donate5000">
                                        <label class="form-check-label" for="donate5000">INR 5,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="10000" id="donate10000">
                                        <label class="form-check-label" for="donate10000">INR 10,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="50000" id="donate50000">
                                        <label class="form-check-label" for="donate50000">INR 50,000.00</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="donation_amount" value="100000" id="donate100000">
                                        <label class="form-check-label" for="donate100000">INR 100,000.00</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="card shadow-sm mb-4 bg-success bg-opacity-10 border-success">
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>PGI OFFERS DISCOUNTED OR FREE TREATMENT TO FINANCIALLY CHALLENGED PATIENTS THROUGH THE "POOR PATIENTS FUND" THAT IS FUNDED BY DONORS LIKE YOU.</strong>
                            </p>
                            <p class="mb-2">
                                ANY AMOUNT WOULD CONTRIBUTE TO A LIFE SAVING MEANS FOR THESE DESTITUTE PATIENTS.
                            </p>
                            <p class="mb-0">
                                <a href="https://pgimer.edu.in/PGIMER_PORTAL/PGIMERPORTAL/GlobalPages/JSP/Page_Data.jsp?dep_id=5676" target="_blank" class="text-success">
                                    PLEASE CLICK HERE TO DONATE.
                                </a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Summit Registration Modal -->
    <div class="modal fade" id="summitRegistrationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register for Summit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You will be redirected to the payment page to complete your registration for Global PGI Alumni Summit 2026.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('alumni.payment') }}" class="btn btn-primary">Proceed to Payment</a>
                </div>
            </div>
        </div>
    </div>

@endsection