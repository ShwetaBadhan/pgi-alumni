@extends('frontend.layout.master')
@section('title', 'Abstract Guidelines | PGI Alumni')
@section('content')

    <!-- Breadcrumb -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Abstract Guidelines</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li><div class="icon-right"><i class="feather-chevron-right"></i></div></li>
                            <li class="rbt-breadcrumb-item active">Guidelines</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guidelines Content -->
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <div class="d-flex justify-content-end mb-4 gap-2">
                        <a href="{{ route('alumni.abstract.create') }}" class="btn btn-primary">
                            Submit Abstract
                        </a>
                        <a href="{{ route('alumni.abstract.my-submissions') }}" class="btn btn-warning text-white">
                            Manage Abstracts
                        </a>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="fw-bold mb-4">Abstract Submission Guidelines</h3>
                            
                            <div class="mb-4">
                                <h5 class="fw-bold">1. Word Limit</h5>
                                <p>Abstract should not exceed 500 words (excluding title, authors, and affiliations).</p>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">2. Format</h5>
                                <ul>
                                    <li>Title: Clear and concise</li>
                                    <li>Authors: List all authors with affiliations</li>
                                    <li>Abstract: Should include background, methods, results, and conclusion</li>
                                </ul>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">3. Content Guidelines</h5>
                                <ul>
                                    <li>Abstract should be original and not published elsewhere</li>
                                    <li>Include key findings and implications</li>
                                    <li>Avoid abbreviations and acronyms</li>
                                    <li>Use clear and simple language</li>
                                </ul>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">4. Submission Process</h5>
                                <ol>
                                    <li>Fill in all required fields</li>
                                    <li>Save as draft if you want to complete later</li>
                                    <li>Review your abstract carefully</li>
                                    <li>Click "Finalize Submission" when ready</li>
                                </ol>
                            </div>

                            <div class="alert alert-info">
                                <strong>Note:</strong> Once finalized, you can still edit your abstract until the submission deadline.
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('alumni.abstract.create') }}" class="btn btn-primary btn-lg">
                                    Start Your Submission
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection