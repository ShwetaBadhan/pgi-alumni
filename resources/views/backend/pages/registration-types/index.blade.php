@extends('backend.layouts.master')

@section('content')
    <div class="dashboard-main-body">

        <!-- Start Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="">
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Registration Types</h1>
                <div class="">
                    <a href="{{ route('dashboard') }}" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                    <span class="text-secondary-light">/ Registration Types</span>
                </div>
            </div>
            <button type="button" class="my-sidebar-btn btn btn-primary-600 d-flex align-items-center gap-6" data-bs-toggle="modal" data-bs-target="#add_registration_type">
                <span class="d-flex text-md">
                    <i class="ri-add-large-line"></i>
                </span>
                New Registration Type
            </button>
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
                        timer: 4000,
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

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const errorList = @json($errors->all()).map(err => `<li>${err}</li>`).join('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `<ul class="text-start mb-0">${errorList}</ul>`,
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>
        @endif

        <!-- Start Registration Types Table Card -->
        <div class="mt-24">
            <div class="card h-100">
                <div class="card-body p-0 dataTable-wrapper">

                    <!-- Table Toolbar -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-16 px-20 py-12 border-bottom border-neutral-200">
                        <div class="d-flex flex-wrap align-items-center gap-16">
                            <form class="navbar-search dt-search m-0">
                                <input type="text" class="dt-input bg-transparent radius-4" aria-controls="dataTable" name="search" placeholder="Search...">
                                <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                            </form>
                        </div>
                        <div class="d-flex align-items-center gap-8 text-secondary-light">
                            <span>Rows per page:</span>
                            <div class="dt-length">
                                <select name="dataTable_length" aria-controls="dataTable" class="dt-input form-control form-select">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="p-0">
                        <table class="table bordered-table mb-0 data-table" id="dataTable" data-page-length='10'>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Type Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrationTypes as $key => $type)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-12">
                                                <div class="avatar avatar-md bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center overflow-hidden rounded-circle">
                                                    <i class="ri-ticket-line fs-20"></i>
                                                </div>
                                                <div>
                                                    <p class="fw-medium text-dark mb-0">{{ $type->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-medium">{{ number_format($type->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $type->status === 'active' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $type->status === 'active' ? 'success' : 'danger' }} border border-{{ $type->status === 'active' ? 'success' : 'danger' }} px-2 py-1 fs-13 fw-medium">
                                                {{ ucfirst($type->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $type->created_at ? $type->created_at->format('d M Y') : '—' }}</td>
                                        <td>
                                            <div class="btn-group dropstart">
                                                <button type="button" class="text-secondary-light text-xl" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end border p-12">
                                                    <li>
                                                        <button type="button" class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6" data-bs-toggle="modal" data-bs-target="#edit_type{{ $type->id }}">
                                                            <i class="ri-edit-2-line"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item rounded text-danger bg-hover-danger bg-opacity-10 text-hover-danger d-flex align-items-center gap-2 py-6" type="button" data-bs-toggle="modal" data-bs-target="#delete_type{{ $type->id }}">
                                                            <i class="ri-delete-bin-6-line"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No registration types found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Registration Types Table Card -->


        <!-- ========================
             Modals Section
        ========================== -->

        <!-- Start Add Registration Type Modal -->
        <div id="add_registration_type" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-dark modal-title fw-bold">New Registration Type</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                    </div>
                    <form action="{{ route('registration-types.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Type Name<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g., VIP, Standard, Early Bird" required value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Amount<span class="text-danger ms-1">*</span></label>
                                <input type="number" name="amount" class="form-control" placeholder="0.00" step="0.01" min="0" required value="{{ old('amount') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ old('status') === 'active' || old('status') === null ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Type</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Registration Type Modal -->

        <!-- Start Edit & Delete Modals (Generated per type) -->
        @foreach ($registrationTypes as $type)
            <!-- Edit Registration Type Modal -->
            <div id="edit_type{{ $type->id }}" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="text-dark modal-title fw-bold">Edit Registration Type</h4>
                            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                        </div>
                        <form action="{{ route('registration-types.update', $type->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Type Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $type->name) }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Amount<span class="text-danger ms-1">*</span></label>
                                    <input type="number" name="amount" value="{{ old('amount', $type->amount) }}" class="form-control" step="0.01" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ old('status', $type->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $type->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer d-flex align-items-center gap-1">
                                <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Registration Type Modal -->
            <div class="modal fade" id="delete_type{{ $type->id }}">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-body text-center position-relative z-1">
                            <img src="{{ asset('assets/img/bg/delete-modal-bg-01.png') }}" alt="" class="img-fluid position-absolute top-0 start-0 z-n1">
                            <img src="{{ asset('assets/img/bg/delete-modal-bg-02.png') }}" alt="" class="img-fluid position-absolute bottom-0 end-0 z-n1">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-danger text-white"><i class="ti ti-trash fs-24"></i></span>
                            </div>
                            <h5 class="fw-bold mb-1">Delete Confirmation</h5>
                            <p class="mb-3">Are you sure you want to delete <strong>{{ $type->name }}</strong>?</p>
                            <p class="mb-3 small text-muted">This action cannot be undone.</p>
                            <form action="{{ route('registration-types.destroy', $type->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-light position-relative z-1" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger position-relative z-1">Yes, Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- End Edit & Delete Modals -->

    </div>
@endsection

@push('scripts')
    <script>
        // ✅ Data Table start
        $('.data-table').each(function () {
            const $table = $(this);
            const tableInstance = new DataTable(this, {
                paging: true,
                searching: false, // We use custom search below
                lengthChange: false // We use custom length change below
            });

            // Handle custom search input (inside same wrapper)
            $table.closest('.dataTable-wrapper').find('.dt-search .dt-input').on('keyup', function () {
                tableInstance.search(this.value).draw();
            });

            // Handle custom page length change (inside same wrapper)
            $table.closest('.dataTable-wrapper').find('.dt-length .dt-input').on('change', function () {
                const value = $(this).val();
                tableInstance.page.len(value).draw();
            });
        });
        // ✅ Data Table end

        // Sidebar js start
        $('.my-sidebar-btn').on('click', function () {
            $('.my-sidebar').addClass('active');
            $('.overlay').addClass('active');
        });
        $('.close-my-sidebar, .overlay').on('click', function () {
            $('.my-sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });
        // Sidebar js end
    </script>
@endpushs