@extends('frontend.layout.master')
@section('title', 'Alumni Publications | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Alumni Publications</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Alumni Publications</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->


    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <a href="https://pgialumni.org/wp-content/uploads/2022/04/Volume-1_DTM-Alumni-Periodical.pdf"
                        target="_blank">
                        <img src="assets/images/publications/Volume-1_DTM-Alumni-Periodical-pdf.jpg" alt="">
                    </a>
                    <div class="form-group mt--60 text-center">
                        <a href="https://pgialumni.org/wp-content/uploads/2022/04/Volume-1_DTM-Alumni-Periodical.pdf"
                            target="_blank" class="rbt-btn rbt-switch-btn btn-gradient radius-round btn-sm" type="submit">
                            <span data-text="View PDF">View PDF</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <a href="https://pgialumni.org/wp-content/uploads/2022/04/Volume-2_DTM-Alumni-Periodical.pdf"
                        target="_blank">
                        <img src="assets/images/publications/Volume-2_DTM-Alumni-Periodical-pdf.jpg" alt="">
                    </a>
                    <div class="form-group mt--60 text-center">
                        <a href="https://pgialumni.org/wp-content/uploads/2022/04/Volume-2_DTM-Alumni-Periodical.pdf"
                            target="_blank" class="rbt-btn rbt-switch-btn btn-gradient radius-round btn-sm" type="submit">
                            <span data-text="View PDF">View PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
