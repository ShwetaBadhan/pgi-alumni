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
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Profile of {{ $alumniRegistration->full_name }}</h1>
                <div>
                    <a href="{{ route('alumni-registrations.index') }}"
                        class="text-secondary-light hover-text-primary hover-underline">Registrations</a>
                    <span class="text-secondary-light">/ {{ $alumniRegistration->firstname }}</span>
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
                            @if ($alumniRegistration->profile_photo)
                                <img src="{{ asset('storage/' . $alumniRegistration->profile_photo) }}"
                                    alt="Profile Picture" class="rounded-circle border border-3 border-primary shadow-sm"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="avatar avatar-xxl bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm"
                                    style="width: 150px; height: 150px;">
                                    <i class="ri-user-line" style="font-size: 60px;"></i>
                                </div>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-1">{{ $alumniRegistration->full_name }}</h5>

                        <!-- Membership ID Badge -->
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
                                    <td class="fw-semibold text-muted" style="width: 35%; padding: 12px 20px;">Username / ID
                                    </td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->contact_number }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Email</td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->email }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Membership ID</td>
                                    <td style="padding: 12px 20px;">
                                        @if ($alumniRegistration->status === 'approved')
                                            <span
                                                class="fw-bold text-primary">{{ str_pad($alumniRegistration->membership_id, 4, '0', STR_PAD_LEFT) }}</span>
                                        @else
                                            <span class="text-muted">Pending Approval</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Contact Number</td>
                                    <td style="padding: 12px 20px;">+91-{{ $alumniRegistration->contact_number }}</td>
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
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">First Name</td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->firstname }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Created at</td>
                                    <td style="padding: 12px 20px;">{{ $alumniRegistration->created_at->format('d M, Y') }}
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Payment Status</td>
                                    <td style="padding: 12px 20px;">
                                        @if ($alumniRegistration->payments()->where('status', 'success')->exists())
                                            <span class="text-success fw-medium">Success</span>
                                        @elseif($alumniRegistration->status === 'payment_pending')
                                            <span class="text-warning fw-medium">Pending</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-semibold text-muted" style="padding: 12px 20px;">Register for</td>
                                    <td style="padding: 12px 20px;">
                                        {{ $alumniRegistration->registrationType->name ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Data Card -->
        <div class="card mt-24">
            <div class="card-header border-bottom py-12 px-20 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Payment Data</h5>
                @if ($alumniRegistration->payment_transaction_id)
                    <a href="#" class="text-primary text-decoration-none">
                        <i class="ri-receipt-line"></i> Check Receipt
                    </a>
                @endif
            </div>
            <div class="card-body p-20">
                <div class="row g-3">
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Amount Paid</p>
                        <p class="fw-bold text-success mb-0">₹{{ number_format($alumniRegistration->amount_paid, 2) }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Transaction Date</p>
                        <p class="fw-medium mb-0">
                            {{ $alumniRegistration->payment_transaction_date ? $alumniRegistration->payment_transaction_date->format('d M Y') : 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Transaction ID</p>
                        <p class="fw-medium mb-0 text-break">{{ $alumniRegistration->payment_transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted small mb-1">Total Amount (with extras)</p>
                        <p class="fw-bold text-primary mb-0">₹{{ number_format($alumniRegistration->total_amount, 2) }}</p>
                    </div>
                </div>

                @if ($alumniRegistration->payments->isNotEmpty())
                    <hr class="my-3">
                    <h6 class="fw-semibold mb-3">Payment History</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Gateway</th>
                                    <th>Amount</th>
                                    <th>Payment ID</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumniRegistration->payments as $payment)
                                    <tr>
                                        <td class="text-uppercase small">{{ $payment->gateway }}</td>
                                        <td class="fw-medium">
                                            {{ $payment->currency === 'INR' ? '' : '$' }}{{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="small text-break">{{ $payment->gateway_payment_id ?? '-' }}</td>
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
                                        <td class="small">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
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
                <h5 class="mb-0 fw-semibold">Send Email to {{ $alumniRegistration->firstname }}</h5>
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

        <!-- Action Buttons (Approve, Reject, Delete) -->
        <div class="card mt-24">
            <div class="card-body p-20alumni-registrations.refund">
                <h5 class="fw-semibold mb-3">Admin Actions</h5>
                <div class="d-flex flex-wrap gap-2">
                    @if ($alumniRegistration->status !== 'approved')
                        <form action="{{ route('alumni-registrations.approve', $alumniRegistration->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Approve this registration?')">
                                <i class="ri-check-line"></i> Approve
                            </button>
                        </form>
                    @endif

                    @if ($alumniRegistration->status !== 'rejected')
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#rejectModal">
                            <i class="ri-close-circle-line"></i> Reject
                        </button>
                    @endif

                    @if ($alumniRegistration->canBeRefunded())
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#refundModal">
                            <i class="ri-arrow-go-back-line"></i> Refund
                        </button>
                    @endif

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="ri-delete-bin-line"></i> Delete Alumni
                    </button>
                </div>
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
                            <p>Please provide a reason for rejecting <strong>{{ $alumniRegistration->full_name }}</strong>:
                            </p>
                            <textarea name="rejection_reason" class="form-control" rows="3" required
                                placeholder="Enter rejection reason..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Confirm Reject</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Refund Modal -->
        {{-- @if ($alumniRegistration->canBeRefunded())
        <div class="modal fade" id="refundModal" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('alumni-registrations.refund', $alumniRegistration->id) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title">Process Refund</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info small">
                                <strong>Total Paid:</strong> ₹{{ number_format($alumniRegistration->amount_paid, 2) }}
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Refund Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="refund_amount" class="form-control" max="{{ $alumniRegistration->amount_paid }}" value="{{ $alumniRegistration->amount_paid }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Refund Reason <span class="text-danger">*</span></label>
                                <textarea name="refund_reason" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Confirm Refund</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif --}}

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <span class="avatar avatar-lg bg-danger text-white"><i
                                    class="ri-delete-bin-line fs-24"></i></span>
                        </div>
                        <h5 class="fw-bold mb-2">Delete Confirmation</h5>
                        <p class="mb-3">Are you sure you want to delete
                            <strong>{{ $alumniRegistration->full_name }}</strong>?</p>
                        <form action="{{ route('alumni-registrations.destroy', $alumniRegistration->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
