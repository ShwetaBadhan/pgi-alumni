@extends('frontend.layout.master')
@section('title', 'Submit Abstract | PGI Alumni')
@section('content')

    <!-- Breadcrumb -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Submit Abstract</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Submit Abstract</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Abstract Submission Form -->
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="d-flex justify-content-end mb-4 gap-2">
                        <a href="{{ route('alumni.abstract.guidelines') }}" class="btn btn-primary">
                            Abstract Guidelines
                        </a>
                        <a href="{{ route('alumni.abstract.my-submissions') }}" class="btn btn-warning text-white">
                            Manage Abstracts
                        </a>
                    </div>

                    <!-- Validation Errors Display -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Success Message Display -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Error Message Display -->
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form
                        action="{{ isset($submission) ? route('alumni.abstract.update', $submission->id) : route('alumni.abstract.store') }}"
                        method="POST" id="abstractForm">
                        @csrf

                        @if(isset($submission))
                            @method('PUT')

                            @php $remaining = 3 - ($submission->edit_count ?? 0); @endphp
                            @if($remaining > 0)
                                <div class="alert alert-info mb-4">
                                    <i class="feather icon-info"></i> You can edit this abstract <strong>{{ $remaining }} more
                                        time(s)</strong>. After that, only the admin can make changes.
                                    <br><small class="text-muted">Note: Category and Theme cannot be changed during edits.</small>
                                </div>
                            @else
                                <div class="alert alert-danger mb-4">
                                    <i class="feather icon-alert-triangle"></i> Edit limit reached. You cannot edit this abstract
                                    anymore.
                                </div>
                            @endif
                        @endif

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Title *</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $submission->title ?? '') }}" required onkeyup="updateWordCount()">
                        </div>

                        <!-- ✅ Category Dropdown (Readonly in Edit Mode) -->
                        <div class="mb-4">
                            <div class="rbt-modern-select bg-transparent height-45 mb--20">
                                <label class="form-label fw-bold">Category *</label>
                                <select name="category_id" class="select w-100" required {{ isset($submission) ? 'disabled' : '' }}>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $submission->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- Hidden field taaki disabled hone par bhi value submit ho jaye --}}
                                @if(isset($submission))
                                    <input type="hidden" name="category_id" value="{{ $submission->category_id }}">
                                @endif
                            </div>
                        </div>

                        <!-- ✅ Theme Dropdown (Readonly in Edit Mode) -->
                        <div class="mb-4">
                            <div class="rbt-modern-select bg-transparent height-45 mb--20">
                                <label class="form-label fw-bold">Theme *</label>
                                <select name="theme_id" class="select w-100" required {{ isset($submission) ? 'disabled' : '' }}>
                                    <option value="">Select Theme</option>
                                    @foreach($themes as $theme)
                                        <option value="{{ $theme->id }}" {{ (old('theme_id', $submission->theme_id ?? '') == $theme->id) ? 'selected' : '' }}>
                                            {{ $theme->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- Hidden field taaki disabled hone par bhi value submit ho jaye --}}
                                @if(isset($submission))
                                    <input type="hidden" name="theme_id" value="{{ $submission->theme_id }}">
                                @endif
                            </div>
                        </div>

                        <!-- Authors -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Authors:</label>
                            <input type="text" name="authors" class="form-control"
                                value="{{ old('authors', $submission->authors ?? '') }}"
                                placeholder="Comma separated author names">
                        </div>

                        <!-- Co-Author -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Co-Author:</label>
                            <input type="text" name="co_author" class="form-control"
                                value="{{ old('co_author', $submission->co_author ?? '') }}">
                        </div>

                        <!-- Primary Author Affiliation -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Primary Author Affiliation:</label>
                            <input type="text" name="primary_author_affiliation" class="form-control"
                                value="{{ old('primary_author_affiliation', $submission->primary_author_affiliation ?? '') }}">
                        </div>

                        <!-- Abstract Textarea -->
                        <div class="mb-4">

                            <label class="form-label fw-bold">Abstract: *</label>
                            <textarea name="abstract_text" id="abstractText" class="form-control" rows="10" required
                                onkeyup="updateWordCount()">{{ old('abstract_text', $submission->abstract_text ?? '') }}</textarea>
                            <small class="text-muted">Maximum 500 words</small>

                        </div>

                        <!-- Keywords -->
                        {{-- <div class="mb-4">
                            <label class="form-label fw-bold">Keywords</label>
                            <input type="text" name="keywords" class="form-control"
                                value="{{ old('keywords', $submission->keywords ?? '') }}"
                                placeholder="e.g., Cardiology, Research, PGIMER">
                        </div> --}}

                        <!-- Word Count -->
                        <div class="mb-4">
                            <span class="text-muted">Total Word Count: </span>
                            <span id="wordCount" class="fw-bold">0</span>/500
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" name="action" value="draft" class="btn btn-info">
                                Save as Draft
                            </button>
                            <button type="submit" name="action" value="finalize" class="btn btn-warning">
                                Finalize Submission
                            </button>
                            <a href="{{ route('alumni.abstract.my-submissions') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function updateWordCount() {
            const text = document.getElementById('abstractText').value;
            const wordCount = text.trim().split(/\s+/).filter(word => word.length > 0).length;
            document.getElementById('wordCount').textContent = wordCount;

            if (wordCount > 500) {
                document.getElementById('wordCount').classList.add('text-danger');
            } else {
                document.getElementById('wordCount').classList.remove('text-danger');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateWordCount();
        });
    </script>
@endpush