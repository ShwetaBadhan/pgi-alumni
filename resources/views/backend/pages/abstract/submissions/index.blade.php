@extends('backend.layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Abstract Submissions</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET" action="{{ route('abstract.submissions.index') }}" class="row">
                            <input type="hidden" name="tab" value="{{ $tab }}">
                            <div class="col-md-3 mb-2">
                                <select name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="theme" class="form-control">
                                    <option value="">All Themes</option>
                                    @foreach($themes as $theme)
                                        <option value="{{ $theme->id }}" {{ request('theme') == $theme->id ? 'selected' : '' }}>
                                            {{ $theme->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" name="search" class="form-control" placeholder="Search title/author..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary btn-block"><i class="feather icon-search"></i>
                                    Filter</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">



                        <div class="dt-responsive table-responsive">
                            <table class="table bordered-table mb-0 data-table" id="dataTable" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"><input type="checkbox" id="checkAll"></th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Category / Theme</th>

                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submissions as $sub)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            @if($isAdmin || $isOrganizer)
                                                <td><input type="checkbox" class="row-check" name="ids[]" value="{{ $sub->id }}" {{ !$sub->canBeDecidedByOrganizer() ? 'disabled' : '' }}></td>
                                            @else
                                                <td></td>
                                            @endif

                                            <td>
                                                <div class="d-flex align-items-center gap-12">

                                                    <div>
                                                        <p class="fw-medium text-dark mb-0">{{ Str::limit($sub->title, 40) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                @if($sub->authors)
                                                    <p class="fw-medium text-dark mb-0">{{ $sub->authors }}</p>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            <td>{{ $sub->category->name ?? '-' }} / {{ $sub->theme->name ?? '-' }}</td>

                                            <td>
                                                <span
                                                    class="badge bg-{{ $sub->status_label['class'] === 'bg-success' ? 'success' : ($sub->status_label['class'] === 'bg-danger' ? 'danger' : ($sub->status_label['class'] === 'bg-warning text-dark' ? 'warning' : 'secondary')) }} bg-opacity-10 text-{{ $sub->status_label['class'] === 'bg-success' ? 'success' : ($sub->status_label['class'] === 'bg-danger' ? 'danger' : ($sub->status_label['class'] === 'bg-warning text-dark' ? 'warning' : 'secondary')) }} border border-{{ $sub->status_label['class'] === 'bg-success' ? 'success' : ($sub->status_label['class'] === 'bg-danger' ? 'danger' : ($sub->status_label['class'] === 'bg-warning text-dark' ? 'warning' : 'secondary')) }} px-2 py-1 fs-13 fw-medium">
                                                    {{ $sub->status_label['label'] }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="btn-group dropstart">
                                                    <button type="button" class="text-secondary-light text-xl"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <iconify-icon icon="tabler:dots-vertical"></iconify-icon>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end border p-12">
                                                        <li>
                                                            <a href="{{ route('abstract.submissions.show', $sub->id) }}"
                                                                class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6">
                                                                <i class="ri-eye-line"></i> View
                                                            </a>
                                                        </li>

                                                        {{-- ✅ Export to Word --}}
                                                        <li>
                                                            <a href="{{ route('submissions.export-word', $sub->id) }}"
                                                                class="dropdown-item rounded text-success bg-hover-success bg-opacity-10 text-hover-success d-flex align-items-center gap-2 py-6">
                                                                <i class="ri-file-word-2-line"></i> Export to Word
                                                            </a>
                                                        </li>


                                                        <li>
                                                            <a href="{{ route('abstract.submissions.edit', $sub->id) }}"
                                                                class="dropdown-item rounded text-info bg-hover-info bg-opacity-10 text-hover-info d-flex align-items-center gap-2 py-6">
                                                                <i class="ri-edit-2-line"></i> Edit
                                                            </a>
                                                        </li>

                                                        {{-- ✅ Delete Option (Only for Admin/Organizer) --}}
                                                        <li>
                                                            <button type="button"
                                                                class="dropdown-item rounded text-danger bg-hover-danger bg-opacity-10 text-hover-danger d-flex align-items-center gap-2 py-6"
                                                                onclick="confirmDelete({{ $sub->id }})">
                                                                <i class="ri-delete-bin-6-line"></i> Delete
                                                            </button>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <button
                                                                class="dropdown-item rounded text-success bg-hover-success bg-opacity-10 text-hover-success d-flex align-items-center gap-2 py-6"
                                                                onclick="decideOne({{ $sub->id }}, 'accept')">
                                                                <i class="ri-check-line"></i> Accept
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button
                                                                class="dropdown-item rounded text-danger bg-hover-danger bg-opacity-10 text-hover-danger d-flex align-items-center gap-2 py-6"
                                                                onclick="decideOne({{ $sub->id }}, 'decline')">
                                                                <i class="ri-close-line"></i> Decline
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
                        {{-- <div class="mt-3">
                            {{ $submissions->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Decision Modal -->
    <div class="modal fade" id="decisionModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="singleDecisionForm" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Record Decision</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="decision" id="modalDecision">
                        <div class="form-group" id="remarkGroup" style="display:none;">
                            <label>Remark for Declining <span class="text-danger">*</span></label>
                            <textarea name="remark" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#submissionTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
            });

            $('#checkAll').on('change', function () {
                $('.row-check:not(:disabled)').prop('checked', this.checked);
            });
        });

        function decideOne(id, decision) {
            $('#modalDecision').val(decision);
            $('#singleDecisionForm').attr('action', `/abstract/submissions/${id}/decide`);

            if (decision === 'decline') {
                $('#remarkGroup').show();
                $('#singleDecisionForm textarea').attr('required', true);
            } else {
                $('#remarkGroup').hide();
                $('#singleDecisionForm textarea').attr('required', false);
            }
            $('#decisionModal').modal('show');
        }

        function triggerBulk(decision) {
            let checked = $('.row-check:checked:not(:disabled)');
            if (checked.length === 0) {
                alert('Please select at least one abstract.');
                return;
            }

            if (decision === 'decline') {
                let remark = prompt("Enter remark for declining (Required):");
                if (!remark) return;
                $('#bulkRemarkValue').val(remark);
            }

            $('#bulkDecisionValue').val(decision);
            $('#bulkDecisionForm').submit();
        }

        // ✅ Delete Confirmation Function
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this abstract submission? This action cannot be undone.')) {
                // Create a temporary form and submit it
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = `/abstract/submissions/${id}`;

                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                let methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush