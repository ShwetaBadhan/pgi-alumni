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
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="theme" class="form-control">
                                <option value="">All Themes</option>
                                @foreach($themes as $theme)
                                    <option value="{{ $theme->id }}" {{ request('theme') == $theme->id ? 'selected' : '' }}>{{ $theme->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search title/author..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-primary btn-block"><i class="feather icon-search"></i> Filter</button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" id="abstractTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $tab === 'needs_decision' ? 'active' : '' }}" href="{{ route('abstract.submissions.index', ['tab' => 'needs_decision'] + request()->only(['category','theme','search'])) }}">
                                Needs Decision
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab === 'accepted' ? 'active' : '' }}" href="{{ route('abstract.submissions.index', ['tab' => 'accepted'] + request()->only(['category','theme','search'])) }}">
                                Accepted
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab === 'others' ? 'active' : '' }}" href="{{ route('abstract.submissions.index', ['tab' => 'others'] + request()->only(['category','theme','search'])) }}">
                                Others
                            </a>
                        </li>
                    </ul>

                    @if($isAdmin || $isOrganizer)
                    <form id="bulkDecisionForm" action="{{ route('abstract.submissions.bulk-decide') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="decision" id="bulkDecisionValue">
                        <input type="hidden" name="remark" id="bulkRemarkValue">
                        <button type="button" class="btn btn-success btn-sm" onclick="triggerBulk('accept')"><i class="feather icon-check"></i> Approve Selected</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="triggerBulk('decline')"><i class="feather icon-x"></i> Decline Selected</button>
                        <a href="{{ route('abstract.submissions.export', request()->all()) }}" class="btn btn-secondary btn-sm"><i class="feather icon-file-text"></i> Export Excel</a>
                    </form>
                    @endif

                    <div class="dt-responsive table-responsive">
                        <table id="submissionTable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    @if($isAdmin || $isOrganizer) <th><input type="checkbox" id="checkAll"></th> @endif
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category / Theme</th>
                                    <th>Reviewer</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $sub)
                                <tr>
                                    @if($isAdmin || $isOrganizer)
                                        <td><input type="checkbox" class="row-check" name="ids[]" value="{{ $sub->id }}" {{ !$sub->canBeDecidedByOrganizer() ? 'disabled' : '' }}></td>
                                    @endif
                                    <td>{{ Str::limit($sub->title, 40) }}</td>
                                    <td>
    @if($sub->alumniUser)
        {{ $sub->alumniUser->firstname }} {{ $sub->alumniUser->lastname }}
        <br><small class="text-muted">{{ $sub->alumniUser->email }}</small>
    @else
        <span class="text-muted">N/A</span>
    @endif
</td>
                                    <td>{{ $sub->category->name ?? '-' }} / {{ $sub->theme->name ?? '-' }}</td>
                                    <td>{{ $sub->reviewer->username ?? 'Unassigned' }}</td>
                                    <td>{{ $sub->reviewer_score ? $sub->reviewer_score.'/10' : '-' }}</td>
                                    <td><span class="badge badge-{{ $sub->status_label['class'] }}">{{ $sub->status_label['label'] }}</span></td>
                                    <td>
                                        <a href="{{ route('abstract.submissions.show', $sub->id) }}" class="btn btn-info btn-sm"><i class="feather icon-eye"></i></a>
                                        
                                        @if(($isAdmin || $isOrganizer) && $sub->canBeDecidedByOrganizer())
                                            <button class="btn btn-success btn-sm" onclick="decideOne({{ $sub->id }}, 'accept')"><i class="feather icon-check"></i></button>
                                            <button class="btn btn-danger btn-sm" onclick="decideOne({{ $sub->id }}, 'decline')"><i class="feather icon-x"></i></button>
                                        @endif
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
    $(document).ready(function() {
        $('#submissionTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'pdf', 'print']
        });

        $('#checkAll').on('change', function() {
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
</script>
@endpush