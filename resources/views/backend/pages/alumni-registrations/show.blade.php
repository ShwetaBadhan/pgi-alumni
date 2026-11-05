@extends('backend.layouts.master')

@section('content')
    <div class="dashboard-main-body">

        <!-- SweetAlert Messages -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: @json(session('success')),
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: @json(session('error')),
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        @endif

        <!-- Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div>
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Profile of
                    {{ $alumniRegistration->full_name ?? 'Alumni' }}</h1>
                <div>
                    <a href="{{ route('alumni-registrations.index') }}"
                        class="text-secondary-light hover-text-primary hover-underline">Registrations</a>
                    <span class="text-secondary-light">/ {{ $alumniRegistration->profile->firstname ?? 'Details' }}</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('alumni-registrations.edit', $alumniRegistration->id) }}"
                    class="btn btn-primary-600 d-flex align-items-center gap-2">
                    <i class="ri-edit-2-line"></i> Edit
                </a>
                <a href="{{ route('alumni-registrations.index') }}" class="btn btn-light d-flex align-items-center gap-2">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
            </div>
        </div>

        <div class="row g-24">
            <!-- Left Column: Profile Photo & Membership ID -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center p-24">
                        <div class="mb-3">
                            @if ($alumniRegistration->documents && $alumniRegistration->documents->profile_photo_path)
                                <img src="{{ asset('storage/' . $alumniRegistration->documents->profile_photo_path) }}"
                                    alt="Profile Picture" class="rounded-circle border border-3 border-primary shadow-sm"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="avatar avatar-xxl bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm"
                                    style="width: 150px; height: 150px;">
                                    <i class="ri-user-line" style="font-size: 60px;"></i>
                                </div>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-1">{{ $alumniRegistration->full_name ?? 'N/A' }}</h5>

                        @if ($alumniRegistration->membership_id)
                            <div class="mb-2">
                                <span class="badge bg-dark bg-opacity-10 text-dark border px-3 py-2 fs-14">
                                    <i class="ri-id-card-line me-1"></i> {{ $alumniRegistration->membership_id }}
                                </span>
                            </div>
                        @endif

                        <p class="text-muted small mb-3">
                            {{ $alumniRegistration->registrationType->name ?? 'Alumni Member' }}</p>

                        @php
                            $statusColors = [
                                'approved' => 'success',
                                'pending' => 'warning',
                                'rejected' => 'danger',
                                'payment_pending' => 'secondary',
                                'refunded' => 'info',
                            ];
                            $statusColor = $statusColors[$alumniRegistration->status] ?? 'secondary';
                        @endphp
                        <span
                            class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} border border-{{ $statusColor }} px-3 py-2 fs-14 fw-medium">
                            {{ ucfirst(str_replace('_', ' ', $alumniRegistration->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Profile Details -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-muted" style="width: 35%; padding: 12px 20px;">Email</td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->email }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Contact Number</td>
                                    <td style="padding: 12px 20px;">
                                        +91-{{ $alumniRegistration->profile->contact_number ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">WhatsApp Number</td>
                                    <td style="padding: 12px 20px;">
                                        +91-{{ $alumniRegistration->profile->whatsapp_number ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Degree Completed</td>
                                    <td style="padding: 12px 20px;">
                                        {{ $alumniRegistration->profile->degree_completed ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Department</td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->profile->department ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Year of Passing</td>
                                    <td style="padding: 12px 20px;">
                                        {{ $alumniRegistration->profile->year_of_passing ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Residence Country</td>
                                    <td style="padding: 12px 20px;">
                                        {{ $alumniRegistration->profile->residence_country ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Membership ID</td>
                                    <td style="padding: 12px 20px;">
                                        @if ($alumniRegistration->status === 'approved' && $alumniRegistration->membership_id)
                                            <span
                                                class="fw-bold text-primary">{{ $alumniRegistration->membership_id }}</span>
                                        @else
                                            <span class="text-muted">Pending Approval</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Status</td>
                                    <td style="padding: 12px 20px;">
                                        <span
                                            class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-2 py-1">
                                            {{ ucfirst($alumniRegistration->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Registered On</td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->created_at->format('d M, Y') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

      
        <!-- Payment Data Card -->
        @php
            $latestPayment = $alumniRegistration->payments->sortByDesc('created_at')->first();
        @endphp
        <div class="card mt-24">
            <div class="card-header border-bottom py-12 px-20 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Payment Data</h5>
                @if ($latestPayment && $latestPayment->screenshot_path)
                    <a href="{{ asset('storage/' . $latestPayment->screenshot_path) }}" target="_blank"
                        class="text-primary text-decoration-none">
                        <i class="ri-receipt-line"></i> View Latest Receipt
                    </a>
                @endif
            </div>
            <div class="card-body p-20">
                <div class="row g-3">
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Latest Amount Paid</p>
                        <p class="fw-bold text-success mb-0">
                            ₹{{ $latestPayment ? number_format($latestPayment->amount, 2) : '0.00' }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Transaction Date</p>
                        <p class="fw-medium mb-0">
                            {{ $latestPayment ? \Carbon\Carbon::parse($latestPayment->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') : 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Transaction ID (UTR)</p>
                        <p class="fw-medium mb-0 text-break">{{ $latestPayment->utr_number ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Payment Status</p>
                        <p class="fw-medium mb-0">
                            @if ($latestPayment)
                                <span
                                    class="badge bg-{{ $latestPayment->status == 'pending' ? 'warning' : 'success' }} bg-opacity-10 text-{{ $latestPayment->status == 'pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($latestPayment->status) }}
                                </span>
                            @else
                                <span class="text-muted">No Payment Yet</span>
                            @endif
                        </p>
                    </div>

                    <!-- Screenshot Preview Section -->
                    <div class="col-12 mt-3">
                        <p class="text-muted small mb-2 fw-semibold">Latest Uploaded Payment Screenshot:</p>
                        @if ($latestPayment && $latestPayment->screenshot_path)
                            <div class="border rounded p-2 bg-light d-inline-block">
                                <a href="{{ asset('storage/' . $latestPayment->screenshot_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $latestPayment->screenshot_path) }}"
                                        alt="Payment Screenshot" class="img-fluid rounded shadow-sm"
                                        style="max-height: 250px; max-width: 100%; object-fit: contain;">
                                </a>
                            </div>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $latestPayment->screenshot_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="ri-external-link-line"></i> Open in New Tab
                                </a>
                            </div>
                        @else
                            <span class="badge bg-secondary">No Screenshot Uploaded Yet</span>
                        @endif
                    </div>
                </div>

                @if ($alumniRegistration->payments->isNotEmpty())
                    <hr class="my-3">
                    <h6 class="fw-semibold mb-3">Complete Payment History</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Gateway</th>
                                    <th>UTR / Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Screenshot</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumniRegistration->payments->sortByDesc('created_at') as $payment)
                                    <tr>
                                        <td class="text-uppercase small">{{ $payment->gateway }}</td>
                                        <td class="fw-bold text-primary small">
                                            {{ $payment->utr_number ?? ($payment->gateway_payment_id ?? '-') }}</td>
                                        <td class="fw-medium">₹{{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            @if ($payment->type == 'donation')
                                                <span class="badge text-white"
                                                    style="background-color: #6f42c1; font-size: 0.75rem;">Donation</span>
                                            @elseif($payment->type == 'accompanying')
                                                <span class="badge bg-info text-dark"
                                                    style="font-size: 0.75rem;">Accompanying</span>
                                            @else
                                                <span class="badge bg-primary"
                                                    style="font-size: 0.75rem;">Membership</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment->screenshot_path)
                                                <a href="{{ asset('storage/' . $payment->screenshot_path) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-info">
                                                    <i class="ri-image-line"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $pColors = [
                                                    'success' => 'success',
                                                    'pending' => 'warning',
                                                    'failed' => 'danger',
                                                    'refunded' => 'secondary',
                                                ];
                                                $pColor = $pColors[$payment->status] ?? 'secondary';
                                            @endphp
                                            <span
                                                class="badge bg-{{ $pColor }} bg-opacity-10 text-{{ $pColor }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="small">
                                            {{ \Carbon\Carbon::parse($payment->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>
                                        <td>
                                            @if ($payment->status == 'pending')
                                                <div class="d-flex gap-1">
                                                    <form action="{{ route('alumni-payments.approve', $payment->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this payment?')">
                                                            <i class="ri-check-line"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="rejectPayment({{ $payment->id }})">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Send Email Section -->
        <div class="card mt-24">
            <div class="card-header border-bottom py-12 px-20">
                <h5 class="mb-0 fw-semibold">Send Email to {{ $alumniRegistration->profile->firstname ?? 'Alumni' }}</h5>
            </div>
            <div class="card-body p-20">
                <form action="{{ route('alumni-registrations.send-email', $alumniRegistration->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter email subject"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Message</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Enter your message..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-mail-send-line"></i> Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('alumni-registrations.reject', $alumniRegistration->id) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Reject Registration</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Please provide a reason for rejecting <strong>{{ $alumniRegistration->full_name ?? 'this alumni' }}</strong>:</p>
                            <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Enter rejection reason..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Confirm Reject</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function confirmApproval() {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will approve the Registration/Membership. Any Donation or Accompanying payments will remain under verification.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, Approve Registration!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approveRegistrationForm').submit();
                }
            });
        }

        function rejectPayment(paymentId) {
            Swal.fire({
                title: 'Reject Payment?',
                text: "Are you sure you want to reject this payment?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reject',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Yahan aap reject payment ka route add kar sakte hain
                    Swal.fire('Rejected!', 'Payment has been rejected.', 'success');
                }
            });
        }
    </script>
@endpush