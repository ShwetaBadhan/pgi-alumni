@extends('backend.layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <br>
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Abstract Details</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('abstract.submissions.index') }}">Submissions</a>
                            </li>
                            <li class="breadcrumb-item active">Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $submission->title }}</h5>
                        <div class="d-flex gap-2 align-items-center">
                            <a href="{{ route('submissions.export-word', $submission->id) }}"
                                class="btn btn-sm btn-success">
                                <i class="feather icon-download"></i> Export to Word
                            </a>
                            {{-- <span class="badge badge-{{ $submission->status_label['class'] ?? 'secondary' }}">
                                {{ $submission->status_label['label'] ?? ucfirst($submission->status) }}
                            </span> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>Abstract Text</h6>
                        <p class="text-justify">{!! nl2br(e($submission->abstract_text)) !!}</p>

                        @if($submission->keywords)
                            <h6 class="mt-4">Keywords</h6>
                            <p>{{ $submission->keywords }}</p>
                        @endif

                        {{-- ✅ Safe check for files --}}
                        @if(isset($submission->files) && $submission->files->isNotEmpty())
                            <h6 class="mt-4">Attached Files</h6>
                            <ul class="list-group">
                                @foreach($submission->files as $file)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="feather icon-file-text mr-2"></i> {{ basename($file->file_path) }}
                                            ({{ number_format($file->file_size / 1024, 2) }} KB)</span>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-primary">Download</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- ✅ Safe check for logs --}}
                @if(isset($submission->logs) && $submission->logs->isNotEmpty())
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Activity Log</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                @foreach($submission->logs as $log)
                                    <li class="mb-2 border-bottom pb-2">
                                        <strong>{{ $log->actor_name ?? 'Unknown' }}
                                            ({{ ucfirst($log->actor_type ?? 'user') }})</strong>
                                        <span
                                            class="text-muted small">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span><br>
                                        Action: <span class="badge badge-secondary">{{ $log->action }}</span>
                                        @if(!empty($log->remarks)) <br><em class="text-muted">"{{ $log->remarks }}"</em> @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Submission Info</h5>
                    </div>
                    <div class="card-body">
                        {{-- ✅ Authors field (comma-separated) --}}
                        <p><strong>Authors:</strong> {{ $submission->authors ?? 'N/A' }}</p>

                        {{-- ✅ Co-Author --}}
                        @if($submission->co_author)
                            <p><strong>Co-Author:</strong> {{ $submission->co_author }}</p>
                        @endif

                        {{-- ✅ Primary Author Affiliation --}}
                        @if($submission->primary_author_affiliation)
                            <p><strong>Affiliation:</strong> {{ $submission->primary_author_affiliation }}</p>
                        @endif

                        {{-- ✅ Registered User Details (alumniUser se) --}}
                        @if($submission->alumniUser)
                            <hr>
                            <p><strong>Submitted By:</strong> {{ $submission->alumniUser->firstname }}
                                {{ $submission->alumniUser->lastname }}
                            </p>
                            <p><strong>Email:</strong> {{ $submission->alumniUser->email ?? 'N/A' }}</p>
                            {{-- <p><strong>Contact:</strong> {{ $submission->alumniUser->contact_number ?? 'N/A' }}</p> --}}
                        @else
                            <p><strong>Email:</strong> N/A</p>
                        @endif

                        <hr>
                        <p><strong>Category:</strong> {{ $submission->category->name ?? 'N/A' }}</p>
                        <p><strong>Theme:</strong> {{ $submission->theme->name ?? 'N/A' }}</p>
                        <p><strong>Submitted:</strong>
                            {{ \Carbon\Carbon::parse($submission->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                        </p>

                        @if($submission->reviewer)
                            <hr>
                            <p><strong>Reviewer:</strong>
                                {{ $submission->reviewer->name ?? $submission->reviewer->username ?? 'N/A' }}
                            </p>
                            <p><strong>Score:</strong> {{ $submission->reviewer_score ?? 'N/A' }}/10</p>
                            <p><strong>Reviewer Remark:</strong> {{ $submission->reviewer_remark ?? 'None' }}</p>
                        @endif

                        @if($submission->organizer)
                            <hr>
                            <p><strong>Organizer Decision:</strong>
                                {{ $submission->organizer_decided_at ? \Carbon\Carbon::parse($submission->organizer_decided_at)->format('d M Y') : 'N/A' }}
                            </p>
                            <p><strong>Organizer Remark:</strong> {{ $submission->organizer_remark ?? 'None' }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection