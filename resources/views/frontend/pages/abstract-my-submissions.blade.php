@extends('frontend.layout.master')
@section('title', 'My Abstract Submissions | PGI Alumni')
@section('content')

    <!-- Breadcrumb -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">My Abstract Submissions</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li><div class="icon-right"><i class="feather-chevron-right"></i></div></li>
                            <li class="rbt-breadcrumb-item active">My Submissions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Submissions -->
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="d-flex justify-content-end mb-4 gap-2">
                        <a href="{{ route('alumni.abstract.guidelines') }}" class="btn btn-primary">
                            Abstract Guidelines
                        </a>
                        <a href="{{ route('alumni.abstract.create') }}" class="btn btn-warning text-white">
                            Submit Abstract
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Finalized Submissions -->
                    <h3 class="fw-bold mb-3">Finalized Submission</h3>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Abstract ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($finalizedSubmissions as $submission)
                                    <tr>
                                        <td>{{ $submission->abstract_id }}</td>
                                        <td>{{ $submission->title }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ ucfirst($submission->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('alumni.abstract.edit', $submission->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="feather icon-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No abstract found....</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Incomplete Submissions -->
                    <h3 class="fw-bold mb-3">Incomplete Submission</h3>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incompleteSubmissions as $submission)
                                    <tr>
                                        <td>{{ $submission->title }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ ucfirst($submission->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('alumni.abstract.edit', $submission->id) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="feather icon-edit"></i> Continue
                                            </a>
                                            <form action="{{ route('alumni.abstract.destroy', $submission->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Delete this submission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="feather icon-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            No abstract found.... Click <a href="{{ route('alumni.abstract.create') }}">here</a> to Submit the Abstract
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Deleted Submissions -->
                    <h3 class="fw-bold mb-3">Deleted Submission</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deletedSubmissions as $submission)
                                    <tr>
                                        <td>{{ $submission->title }}</td>
                                        <td>
                                            <span class="badge bg-danger">Deleted</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                Cannot restore
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No abstract found....</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection