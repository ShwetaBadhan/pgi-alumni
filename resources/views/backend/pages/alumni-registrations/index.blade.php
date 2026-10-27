@extends('backend.layouts.master')

@section('content')
    <div class="dashboard-main-body">

        <!-- Start Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="">
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Alumni Registrations</h1>
                <div class="">
                    <a href="{{ route('dashboard') }}"
                        class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                    <span class="text-secondary-light">/ Alumni Registrations</span>
                </div>
            </div>
            <!-- ADD THIS BUTTON -->
            <a href="{{ route('alumni-registrations.create') }}" class="btn btn-primary-600 d-flex align-items-center gap-6">
                <span class="d-flex text-md">
                    <i class="ri-add-large-line"></i>
                </span>
                New Alumni
            </a>
        </div>
        <!-- End Page Header -->

        <!-- SweetAlert Session Messages -->
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

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const errorList = @json($errors->all()).map(err => `<li>${err}</li>`).join('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: `<ul class="text-start mb-0">${errorList}</ul>`,
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        @endif

        <!-- Start Table Card -->
        <div class="mt-24">
            <div class="card h-100">
                <div class="card-body p-0 dataTable-wrapper">

                  <!-- Table Toolbar -->
<div class="d-flex align-items-center justify-content-between flex-wrap gap-16 px-20 py-12 border-bottom border-neutral-200">
    <div class="d-flex flex-wrap align-items-center gap-16">
        
        <!-- ✅ EXPORT BUTTON (Sabhi filters preserve karega) -->
        <a href="{{ route('alumni-registrations.export', request()->only(['filter', 'search', 'status'])) }}" 
           class="px-12 py-5-px border border-neutral-300 radius-8 d-flex align-items-center gap-20 text-decoration-none text-secondary-light bg-hover-neutral-200">
            <span class="d-flex align-items-center gap-1 text-sm">
                <i class="ri-file-excel-2-line text-md line-height-1 text-success"></i>
                Export Excel
            </span>
        </a>

        <!-- Search & Filter Form -->
        <form class="navbar-search dt-search m-0 d-flex gap-2" action="{{ route('alumni-registrations.index') }}" method="GET">
            <!-- Hidden inputs taaki search/submit karte waqt filters na hate -->
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif

            <!-- ✅ NEW: Status Filter Dropdown -->
            <select name="status" class="form-select form-select-sm border-neutral-300" style="min-width: 150px;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="payment_pending" {{ request('status') == 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                <option value="payment_failed" {{ request('status') == 'payment_failed' ? 'selected' : '' }}>Payment Failed</option>
                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>

            <!-- Search Input -->
            <div class="input-group" style="max-width: 250px;">
                <input type="text" class="form-control form-control-sm bg-transparent radius-4" name="search"
                    value="{{ request('search') }}" placeholder="Search name, email...">
                <button type="submit" class="btn btn-sm btn-primary border-0">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </button>
            </div>
        </form>
    </div>
    
    <div class="d-flex align-items-center gap-8 text-secondary-light">
        <span>Rows per page:</span>
        <div class="dt-length">
            <select name="dataTable_length" aria-controls="dataTable"
                class="dt-input form-control form-select"
                onchange="window.location.href='?per_page='+this.value + window.location.search.replace('?', '&')">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            </select>
        </div>
    </div>
</div>

                    <!-- Data Table -->
                    <div class="p-0">
                        <div class="table-responsive">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Reg. Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($registrations as $key => $reg)
                                        <tr>
                                            <td>{{ $registrations->firstItem() + $key }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-12">
                                                    <div
                                                        class="avatar avatar-md bg-light text-dark d-flex align-items-center justify-content-center overflow-hidden rounded-circle">
                                                        <i class="ti ti-user fs-20"></i>
                                                    </div>
                                                    <div>
                                                        <p class="fw-medium text-dark mb-0">{{ $reg->full_name }}</p>
                                                        <small class="text-muted">{{ $reg->contact_number }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $reg->email }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary border border-primary px-2 py-1 fs-13 fw-medium">
                                                    {{ $reg->registrationType->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="fw-medium">₹{{ number_format($reg->total_amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'approved' => 'success',
                                                        'pending' => 'warning',
                                                        'rejected' => 'danger',
                                                        'payment_pending' => 'secondary',
                                                    ];
                                                    $color = $statusColors[$reg->status] ?? 'secondary';
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} border border-{{ $color }} px-2 py-1 fs-13 fw-medium">
                                                    {{ ucfirst(str_replace('_', ' ', $reg->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $reg->created_at->format('d M Y') }}</td>
                                            <td>
                                                <div class="btn-group dropstart">
                                                    <button type="button" class="text-secondary-light text-xl"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end border p-12">
                                                        <li>
                                                            <a class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6"
                                                                href="{{ route('alumni-registrations.show', $reg->id) }}">
                                                                <i class="ri-eye-line"></i> View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6"
                                                                href="{{ route('alumni-registrations.edit', $reg->id) }}">
                                                                <i class="ri-edit-2-line"></i> Edit
                                                            </a>
                                                        </li>
                                                        @if ($reg->status !== 'approved')
                                                            <li>
                                                                <form
                                                                    action="{{ route('alumni-registrations.approve', $reg->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="dropdown-item rounded text-success bg-hover-success bg-opacity-10 text-hover-success d-flex align-items-center gap-2 py-6">
                                                                        <i class="ri-check-line"></i> Approve
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item rounded text-warning bg-hover-warning bg-opacity-10 text-hover-warning d-flex align-items-center gap-2 py-6"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#rejectModal{{ $reg->id }}">
                                                                    <i class="ri-close-circle-line"></i> Reject
                                                                </button>
                                                            </li>
                                                        @endif

                                                        <li>
                                                            <button
                                                                class="dropdown-item rounded text-danger bg-hover-danger bg-opacity-10 text-hover-danger d-flex align-items-center gap-2 py-6"
                                                                type="button" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $reg->id }}">
                                                                <i class="ri-delete-bin-6-line"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $reg->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form action="{{ route('alumni-registrations.reject', $reg->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fw-bold">Reject Registration</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Please provide a reason for rejecting
                                                                <strong>{{ $reg->full_name }}</strong>:
                                                            </p>
                                                            <textarea name="rejection_reason" class="form-control" rows="3" required
                                                                placeholder="Enter rejection reason..."></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Confirm
                                                                Reject</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $reg->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center position-relative z-1">
                                                        <img src="{{ asset('assets/img/bg/delete-modal-bg-01.png') }}"
                                                            alt=""
                                                            class="img-fluid position-absolute top-0 start-0 z-n1">
                                                        <img src="{{ asset('assets/img/bg/delete-modal-bg-02.png') }}"
                                                            alt=""
                                                            class="img-fluid position-absolute bottom-0 end-0 z-n1">
                                                        <div class="mb-3">
                                                            <span class="avatar avatar-lg bg-danger text-white"><i
                                                                    class="ti ti-trash fs-24"></i></span>
                                                        </div>
                                                        <h5 class="fw-bold mb-1">Delete Confirmation</h5>
                                                        <p class="mb-3">Are you sure you want to delete
                                                            <strong>{{ $reg->full_name }}</strong>?
                                                        </p>
                                                        <form
                                                            action="{{ route('alumni-registrations.destroy', $reg->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="d-flex justify-content-center gap-2">
                                                                <button type="button"
                                                                    class="btn btn-light position-relative z-1"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger position-relative z-1">Yes,
                                                                    Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">No registrations found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="px-20 py-12 border-top border-neutral-200 d-flex justify-content-end">
                        {{ $registrations->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table Card -->
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize DataTables if you are using the jQuery plugin, otherwise remove this block.
        // Since we are using server-side pagination via Laravel, standard DataTables JS is not strictly needed for paging, 
        // but you can keep your custom search JS if you prefer client-side filtering.
    </script>
@endpush
