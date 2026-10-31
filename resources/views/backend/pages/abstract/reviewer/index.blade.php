@extends('backend.layouts.master')

@section('content')
<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Reviewer Assignments</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Assign Reviewers</h5>
                    <form action="{{ route('abstract.reviewers.reroute-pending') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="feather icon-refresh-cw"></i> Auto-Reroute Pending Abstracts
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <!-- Add New Assignment Form -->
                    <form action="{{ route('abstract.reviewers.store') }}" method="POST" class="mb-4 border p-3 rounded">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Reviewer</label>
                                <select name="reviewer_id" class="form-control" required>
                                    <option value="">Select Reviewer</option>
                                    @foreach($reviewers as $rev)
                                        <option value="{{ $rev->_id }}">{{ $rev->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Theme (Optional)</label>
                                <select name="theme_id" class="form-control">
                                    <option value="">All Themes</option>
                                    @foreach($themes as $theme)
                                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary btn-block">Add</button>
                            </div>
                        </div>
                    </form>

                    <!-- Assignments Table -->
                    <div class="dt-responsive table-responsive">
                        <table id="reviewerTable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Reviewer</th>
                                    <th>Category</th>
                                    <th>Theme</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $key => $assignment)
                                <tr>
                                    <td>{{ $assignments->firstItem() + $key }}</td>
                                    <td>{{ $assignment->reviewer->username ?? 'N/A' }}</td>
                                    <td>{{ $assignment->category->name ?? 'N/A' }}</td>
                                    <td>{{ $assignment->theme->name ?? 'All Themes' }}</td>
                                    <td>
                                        <form action="{{ route('abstract.reviewers.updateStatus', $assignment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()" style="width: 100px;">
                                                <option value="1" {{ $assignment->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $assignment->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('abstract.reviewers.destroy', $assignment->id) }}" method="POST" class="d-inline delete-form">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#reviewerTable').DataTable();
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            if(confirm('Are you sure you want to remove this assignment?')) {
                this.submit();
            }
        });
    });
</script>
@endpush