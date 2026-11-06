@extends('backend.layouts.master')

@section('content')
<div class="pcoded-content">
    <br>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Abstract Submission</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('abstract.submissions.index') }}">Submissions</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Abstract Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('abstract.submissions.update', $submission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Title *</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $submission->title) }}" required>
                            </div>

                            <!-- Authors -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Authors</label>
                                <input type="text" name="authors" class="form-control" value="{{ old('authors', $submission->authors) }}" placeholder="Comma separated names">
                            </div>

                            <!-- Co-Author -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Co-Author</label>
                                <input type="text" name="co_author" class="form-control" value="{{ old('co_author', $submission->co_author) }}">
                            </div>

                            <!-- Affiliation -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Primary Author Affiliation</label>
                                <input type="text" name="primary_author_affiliation" class="form-control" value="{{ old('primary_author_affiliation', $submission->primary_author_affiliation) }}">
                            </div>

                            <!-- Category -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Category *</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $submission->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Theme -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Theme *</label>
                                <select name="theme_id" class="form-control" required>
                                    <option value="">Select Theme</option>
                                    @foreach($themes as $theme)
                                        <option value="{{ $theme->id }}" {{ old('theme_id', $submission->theme_id) == $theme->id ? 'selected' : '' }}>
                                            {{ $theme->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Abstract Text -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Abstract Text *</label>
                                <textarea name="abstract_text" class="form-control" rows="6" required>{{ old('abstract_text', $submission->abstract_text) }}</textarea>
                            </div>

                            <!-- Keywords -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Keywords</label>
                                <input type="text" name="keywords" class="form-control" value="{{ old('keywords', $submission->keywords) }}" placeholder="e.g., Cardiology, Research">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status *</label>
                                <select name="status" class="form-control" required>
                                    <option value="draft" {{ old('status', $submission->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="submitted" {{ old('status', $submission->status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                    <option value="sent_to_reviewer" {{ old('status', $submission->status) == 'sent_to_reviewer' ? 'selected' : '' }}>Sent to Reviewer</option>
                                    <option value="reviewer_accepted" {{ old('status', $submission->status) == 'reviewer_accepted' ? 'selected' : '' }}>Reviewer Accepted</option>
                                    <option value="reviewer_rejected" {{ old('status', $submission->status) == 'reviewer_rejected' ? 'selected' : '' }}>Reviewer Rejected</option>
                                    <option value="sent_back" {{ old('status', $submission->status) == 'sent_back' ? 'selected' : '' }}>Sent Back for Revision</option>
                                    <option value="organizer_accepted" {{ old('status', $submission->status) == 'organizer_accepted' ? 'selected' : '' }}>Organizer Accepted</option>
                                    <option value="organizer_rejected" {{ old('status', $submission->status) == 'organizer_rejected' ? 'selected' : '' }}>Organizer Rejected</option>
                                </select>
                            </div>

                            <!-- Reviewer Score -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Reviewer Score (out of 10)</label>
                                <input type="number" name="reviewer_score" class="form-control" min="0" max="10" step="0.1" value="{{ old('reviewer_score', $submission->reviewer_score) }}">
                            </div>

                            <!-- Reviewer Remark -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Reviewer Remark</label>
                                <textarea name="reviewer_remark" class="form-control" rows="3">{{ old('reviewer_remark', $submission->reviewer_remark) }}</textarea>
                            </div>

                            <!-- Organizer Remark -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Organizer Remark</label>
                                <textarea name="organizer_remark" class="form-control" rows="3">{{ old('organizer_remark', $submission->organizer_remark) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather icon-save"></i> Update Abstract
                            </button>
                            <a href="{{ route('abstract.submissions.index') }}" class="btn btn-secondary">
                                <i class="feather icon-x"></i> Cancel
                            </a>
                            <a href="{{ route('submissions.export-word', $submission->id) }}" class="btn btn-success ms-auto">
                                <i class="feather icon-download"></i> Export to Word
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection