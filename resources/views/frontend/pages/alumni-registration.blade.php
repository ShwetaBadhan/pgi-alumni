@extends('frontend.layout.master')
@section('title', 'Alumni Registration | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Alumni Registration</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Alumni Registration</li>
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
                <div class="col-lg-12">
                    <div class="rbt-button-group">
                        <a class="rbt-btn rbt-switch-btn btn-gradient radius-round btn-sm" href="{{ route('alumni-login') }}">If you are a
                            Member Click Here</a>
                        <a class="rbt-btn rbt-switch-btn btn-gradient radius-round btn-sm" href="{{ route('registration-new') }}">If you are not a
                            Member Click Here</a>
                        <a class="rbt-btn rbt-switch-btn btn-gradient radius-round btn-sm" href="{{ route('get-your-membership-id') }}">Find Your Member
                            ID</a>

                        <h5 class="mt--60 text-center">Important Note : For all the International Payments, you will
                            redirect to our Event Manager's website (Eventful.co.in).</h5>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="https://pgialumni.org/wp-content/uploads/2024/04/tmc__1_-removebg-preview.png" alt="">
                </div>
                <div class="col-lg-4 text-center">
                    <p>Our Event Partners: <b> Tee Mac Corporation</b></p>
                    <p> Partner’s Website: <b> <a href="eventful.co.in" target="_blank">eventful.co.in</a></b></p>
                    <p> This Website Is Owned And Maintained By

                        <b> <a href="eventful.co.in" target="_blank">Tee Mac Corporation</a></b>
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="https://pgialumni.org/wp-content/uploads/2024/04/eventful__1_-removebg-preview.png"
                        alt="">
                </div>
            </div>
        </div>
    </div>



@endsection
