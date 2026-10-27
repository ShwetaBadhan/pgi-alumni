@extends('backend.layouts.master')

@section('content')
<div class="dashboard-main-body">

    <!-- Start Page Header -->
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="">
            <h1 class="fw-semibold mb-4 h6 text-primary-light">Permissions</h1>
            <div class="">
                <a href="{{ route('dashboard') }}" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                <span class="text-secondary-light">/ Permissions</span>
            </div>
        </div>
        <button type="button" class="my-sidebar-btn btn btn-primary-600 d-flex align-items-center gap-6" data-bs-toggle="modal" data-bs-target="#add_permission">
            <span class="d-flex text-md">
                <i class="ri-add-large-line"></i>
            </span>
            New Permission
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

    <!-- Start Permissions Table Card -->
    <div class="mt-24">
        <div class="card h-100">
            <div class="card-body p-0 dataTable-wrapper">

                <!-- Table Toolbar -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-16 px-20 py-12 border-bottom border-neutral-200">
                    <div class="d-flex flex-wrap align-items-center gap-16">
                        <div class="dropdown">
                            <button type="button" class="px-12 py-5-px border border-neutral-300 radius-8 d-flex align-items-center gap-20" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-flex align-items-center gap-1 text-secondary-light text-sm">
                                    <i class="ri-file-upload-line text-md line-height-1"></i>
                                    Export
                                </span>
                                <span class="">
                                    <i class="ri-arrow-down-s-line"></i>
                                </span>
                            </button>
                            <ul class="dropdown-menu p-12 border bg-base shadow">
                                <li>
                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-10">
                                        <i class="ri-file-3-line"></i> PDF
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-10">
                                        <i class="ri-file-excel-line"></i> Excel
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <form class="navbar-search dt-search m-0">
                            <input type="text" class="dt-input bg-transparent radius-4" aria-controls="dataTable" name="search" placeholder="Search permissions...">
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
                                <th scope="col">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th scope="col">Permission</th>
                                <th scope="col">Group</th>
                                <th scope="col">Guard</th>
                                <th scope="col">Created On</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="selected_permissions[]" value="{{ $permission->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-medium text-dark mb-0">{{ $permission->name }}</p>
                                    </td>
                                    <td>
                                        @if ($permission->group_name)
                                            
                                                {{ $permission->group_name }}
                                            
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $permission->guard_name }}</small></td>
                                    <td>{{ $permission->created_at ? $permission->created_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $permission->status ? 'success' : 'danger' }} bg-opacity-10 text-{{ $permission->status ? 'success' : 'danger' }} border border-{{ $permission->status ? 'success' : 'danger' }} px-2 py-1 fs-13 fw-medium">
                                            {{ $permission->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="text-primary-light text-xl" data-bs-toggle="dropdown" aria-expanded="false">
                                                <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg-end border p-12">
                                                <li>
                                                    <button type="button" class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6" data-bs-toggle="modal" data-bs-target="#edit_permission{{ $permission->id }}">
                                                        <i class="ri-edit-2-line"></i> Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6" type="button" data-bs-toggle="modal" data-bs-target="#delete_permission{{ $permission->id }}">
                                                        <i class="ri-delete-bin-6-line"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Permissions Table Card -->


    <!-- ========================
         Modals Section
    ========================== -->

    <!-- Start Add Permission Modal -->
    <div id="add_permission" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-dark modal-title fw-bold">New Permission</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Permission Name -->
                        <div class="mb-3">
                            <label class="form-label">Permission Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., view reports, manage settings" required value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Group Name (Optional) -->
                        <div class="mb-3">
                            <label class="form-label">Group <small class="text-muted">(Optional)</small></label>
                            <input type="text" name="group_name" class="form-control" placeholder="e.g., Users, Reports, Settings" value="{{ old('group_name') }}">
                            <small class="text-muted">Used to organize permissions in lists</small>
                        </div>

                        <!-- Guard Name -->
                        <div class="mb-3">
                            <label class="form-label">Guard</label>
                            <select name="guard_name" class="form-select">
                                <option value="web" {{ old('guard_name') == 'web' || old('guard_name') === null ? 'selected' : '' }}>Web</option>
                                <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>API</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-0">
                            <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="1" {{ old('status') == '1' || old('status') === null ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Permission Modal -->

    <!-- Start Edit & Delete Modals (Generated per permission) -->
    @foreach ($permissions as $permission)
        
        <!-- Edit Permission Modal -->
        <div id="edit_permission{{ $permission->id }}" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-dark modal-title fw-bold">Edit Permission</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <!-- Permission Name -->
                            <div class="mb-3">
                                <label class="form-label">Permission Name<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="form-control" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Assign to Roles Section -->
                            <div class="mb-3">
                                <label class="form-label">Assign to Roles <small class="text-muted">(Optional)</small></label>
                                <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($allRoles as $roleItem)
                                        <div class="form-check">
                                            <input type="checkbox" name="roles[]" value="{{ $roleItem->name }}" id="role_{{ $permission->id }}_{{ $roleItem->id }}" class="form-check-input" {{ $permission->roles->contains('name', $roleItem->name) ? 'checked' : '' }}>
                                            <label for="role_{{ $permission->id }}_{{ $roleItem->id }}" class="form-check-label">
                                                {{ $roleItem->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Group Name -->
                            <div class="mb-3">
                                <label class="form-label">Group <small class="text-muted">(Optional)</small></label>
                                <input type="text" name="group_name" value="{{ old('group_name', $permission->group_name) }}" class="form-control">
                            </div>

                            <!-- Guard Name -->
                            <div class="mb-3">
                                <label class="form-label">Guard</label>
                                <select name="guard_name" class="form-select">
                                    <option value="web" {{ old('guard_name', $permission->guard_name) == 'web' ? 'selected' : '' }}>Web</option>
                                    <option value="api" {{ old('guard_name', $permission->guard_name) == 'api' ? 'selected' : '' }}>API</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="mb-0">
                                <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="1" {{ old('status', $permission->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $permission->status) == '0' ? 'selected' : '' }}>Inactive</option>
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

        <!-- Delete Permission Modal -->
        <div class="modal fade" id="delete_permission{{ $permission->id }}">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center position-relative z-1">
                        <img src="{{ asset('assets/img/bg/delete-modal-bg-01.png') }}" alt="" class="img-fluid position-absolute top-0 start-0 z-n1">
                        <img src="{{ asset('assets/img/bg/delete-modal-bg-02.png') }}" alt="" class="img-fluid position-absolute bottom-0 end-0 z-n1">
                        <div class="mb-3">
                            <span class="avatar avatar-lg bg-danger text-white rounded-circle">
                                <i class="ti ti-trash fs-24"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold mb-1">Delete Confirmation</h5>
                        <p class="mb-3">Are you sure you want to delete <strong>{{ $permission->name }}</strong>?</p>
                        <p class="mb-3 small text-muted">This action cannot be undone.</p>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
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

    <!-- Initialize Select Plugins for Modals -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize select for Add Permission Modal
            const addModal = document.getElementById('add_permission');
            if (addModal) {
                addModal.addEventListener('shown.bs.modal', function() {
                    if (typeof $.fn.select2 !== 'undefined') {
                        $(this).find('.select').select2({
                            dropdownParent: $(this),
                            width: '100%'
                        });
                    }
                });
            }

            // Initialize select for all Edit Permission Modals
            document.querySelectorAll('[id^="edit_permission"]').forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    if (typeof $.fn.select2 !== 'undefined') {
                        $(this).find('.select').select2({
                            dropdownParent: $(this),
                            width: '100%'
                        });
                    }
                });
            });
        });
    </script>

   
</div>
@endsection
@push('scripts')
      <script>
    let table = new DataTable('#dataTable');

    // ✅ Data Table start
    $('.data-table').each(function () {
        const $table = $(this);
        const tableInstance = new DataTable(this);

        // Handle search input (inside same wrapper)
        $table.closest('.dataTable-wrapper').find('.dt-search .dt-input').on('keyup', function () {
            tableInstance.search(this.value).draw();
        });

        // Handle page length change (inside same wrapper)
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


    $('.edit-sidebar-btn').on('click', function () {
        $('.edit-sidebar').addClass('active');
        $('.overlay').addClass('active');
    });
    $('.close-edit-sidebar, .overlay').on('click', function () {
        $('.edit-sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });
    // Sidebar js end

</script>
@endpush