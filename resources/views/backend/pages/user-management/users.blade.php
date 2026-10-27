@extends('backend.layouts.master')

@section('content')
    <div class="dashboard-main-body">

        <!-- Start Page Header -->
        <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="">
                <h1 class="fw-semibold mb-4 h6 text-primary-light">Users</h1>
                <div class="">
                    <a href="{{ route('dashboard') }}" class="text-secondary-light hover-text-primary hover-underline">Dashboard </a>
                    <span class="text-secondary-light">/ Users</span>
                </div>
            </div>
            <button type="button" class="my-sidebar-btn btn btn-primary-600 d-flex align-items-center gap-6" data-bs-toggle="modal" data-bs-target="#add_user">
                <span class="d-flex text-md">
                    <i class="ri-add-large-line"></i>
                </span>
                New User
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

        <!-- Start Users Table Card -->
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
                                   
                                    <th scope="col">User</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Joined</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                       
                                        <td>
                                            <div class="d-flex align-items-center gap-12">
                                                <div class="avatar avatar-md bg-light text-dark d-flex align-items-center justify-content-center overflow-hidden rounded-circle">
                                                    @if ($user->profile_photo)
                                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo" class="img-fluid" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <i class="ti ti-user fs-20"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="fw-medium text-dark mb-0">{{ $user->name }}</p>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($user->roles->isNotEmpty())
                                               
                                                    {{ $user->roles->first()->name }}
                                                
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->phone ?? '—' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->status ? 'success' : 'danger' }} bg-opacity-10 text-{{ $user->status ? 'success' : 'danger' }} border border-{{ $user->status ? 'success' : 'danger' }} px-2 py-1 fs-13 fw-medium">
                                                {{ $user->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="text-primary-light text-xl" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-lg-end border p-12">
                                                    <li>
                                                        <button type="button" class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6" data-bs-toggle="modal" data-bs-target="#edit_user{{ $user->id }}">
                                                            <i class="ri-edit-2-line"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6" type="button" data-bs-toggle="modal" data-bs-target="#delete_user{{ $user->id }}">
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
        <!-- End Users Table Card -->


        <!-- ========================
             Modals Section
        ========================== -->

        <!-- Start Add User Modal -->
        <div id="add_user" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-dark modal-title fw-bold">New User</h4>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Full name" required value="{{ old('name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email address" required value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone number" maxlength="20" value="{{ old('phone') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role<span class="text-danger ms-1">*</span></label>
                                <select name="role" class="form-select" required>
                                    @foreach ($roles as $roleOption)
                                        <option value="{{ $roleOption->name }}">{{ $roleOption->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password<span class="text-danger ms-1">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password<span class="text-danger ms-1">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="1" {{ old('status') === '1' || old('status') === null ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control" accept="image/png, image/jpeg, image/gif">
                                <small class="text-muted">Max 800KB • JPG, JPEG, PNG, GIF</small>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add User Modal -->

        <!-- Start Edit & Delete Modals (Generated per user) -->
        @foreach ($users as $user)
            <!-- Edit User Modal -->
            <div id="edit_user{{ $user->id }}" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="text-dark modal-title fw-bold">Edit User</h4>
                            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                        </div>
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" maxlength="20">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role<span class="text-danger ms-1">*</span></label>
                                    <select name="role" class="form-select" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                    <input type="password" name="password" class="form-control" placeholder="Min 8 characters">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status<span class="text-danger ms-1">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Current Photo</label>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
                                            <span class="text-muted small">{{ basename($user->profile_photo) }}</span>
                                        @else
                                            <span class="text-muted small">No photo</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Change Photo</label>
                                    <input type="file" name="profile_photo" class="form-control" accept="image/png, image/jpeg, image/gif">
                                    <small class="text-muted">Max 800KB • JPG, JPEG, PNG, GIF</small>
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

            <!-- Delete User Modal -->
            <div class="modal fade" id="delete_user{{ $user->id }}">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-body text-center position-relative z-1">
                            <img src="{{ asset('assets/img/bg/delete-modal-bg-01.png') }}" alt="" class="img-fluid position-absolute top-0 start-0 z-n1">
                            <img src="{{ asset('assets/img/bg/delete-modal-bg-02.png') }}" alt="" class="img-fluid position-absolute bottom-0 end-0 z-n1">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-danger text-white"><i class="ti ti-trash fs-24"></i></span>
                            </div>
                            <h5 class="fw-bold mb-1">Delete Confirmation</h5>
                            <p class="mb-3">Are you sure you want to delete <strong>{{ $user->name }}</strong>?</p>
                            <p class="mb-3 small text-muted">This action cannot be undone.</p>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
                document.querySelectorAll('[id^="edit_user"]').forEach(modal => {
                    modal.addEventListener('shown.bs.modal', function() {
                        if (typeof $.fn.select2 !== 'undefined') {
                            $(this).find('.select').select2({
                                dropdownParent: $(this),
                                width: '100%'
                            });
                        }
                    });
                });
                
                // Also initialize for the Add User modal
                const addModal = document.getElementById('add_user');
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