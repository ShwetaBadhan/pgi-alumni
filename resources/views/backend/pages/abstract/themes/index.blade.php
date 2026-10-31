@extends('backend.layouts.master')

@section('content')
<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Abstract Themes</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:">Abstract Themes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>All Themes</h5>
                    <!-- Add Button triggers Modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addThemeModal">
                        <i class="feather icon-plus"></i> Add New Theme
                    </button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="themeTable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Theme Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($themes as $key => $theme)
                                <tr>
                                    <td>{{ $themes->firstItem() + $key }}</td>
                                    <td>{{ $theme->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $theme->status ? 'success' : 'danger' }}">
                                            {{ $theme->status ? 'Enable' : 'Disable' }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Edit Button triggers Modal with data attributes -->
                                        <button type="button" class="btn btn-info btn-sm edit-btn" 
                                            data-id="{{ $theme->id }}" 
                                            data-name="{{ $theme->name }}" 
                                            data-status="{{ $theme->status }}"
                                            data-bs-toggle="modal" data-bs-target="#editThemeModal">
                                            <i class="feather icon-edit"></i>
                                        </button>
                                        
                                        <form action="{{ route('abstract.themes.destroy', $theme->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="feather icon-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $themes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= ADD THEME MODAL ================= -->
<div class="modal fade" id="addThemeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('abstract.themes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Theme Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Theme</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT THEME MODAL ================= -->
<div class="modal fade" id="editThemeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_theme_id" name="id">
                    <div class="form-group mb-3">
                        <label>Theme Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select id="edit_status" name="status" class="form-control" required>
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Theme</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#themeTable').DataTable();
        
        // Delete Confirmation
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Populate Edit Modal with Data dynamically
        $('.edit-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const status = $(this).data('status');
            
            // Set form action dynamically
            $('#editForm').attr('action', `/abstract/themes/${id}`);
            
            // Populate fields
            $('#edit_theme_id').val(id);
            $('#edit_name').val(name);
            $('#edit_status').val(status);
        });

        // Clear validation errors when modal closes
        $('#addThemeModal, #editThemeModal').on('hidden.bs.modal', function () {
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.text-danger.small').remove();
        });
    });
</script>

{{-- SweetAlert for Session Messages --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: "{{ session('error') }}",
        confirmButtonColor: '#d33'
    });
</script>
@endif
@endpush