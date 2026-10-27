@extends('frontend.layout.master')
@section('title', 'Objectives | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Objectives</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Objectives</li>
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
               <h5 class="mb-4">The major objectives of the PGI Alumni Relations Cell are:</h5>
               <ul class="plan-offer-list rbt-list-primary-opacity mt-5">
                        <li>
                            <i class="feather-check"></i> To promote interaction amongst PGI Alumni members and to serve as a link between the members and the Institute.
                        </li>
                        <li>
                            <i class="feather-check"></i> To conduct academic activities and to award prizes for excellent work done in the medical filed and/or social sphere.
                        </li>
                        <li>
                            <i class="feather-check"></i> To publish or assist in the publication of PGI ALUMNI newsletter, books and/or journals by members of PGI ALUMNI.
                        </li>
                        <li>
                            <i class="feather-check"></i> To work towards improvement of medical education and health care services in the country.
                        </li>
                        <li>
                            <i class="feather-check"></i> To raise various endowment funds and award stipends out of it to the deserving students on need-cum-merit basis within the Institute.
                        </li>
                        <li>
                            <i class="feather-check"></i> To institute and disburse scholarships, fellowships, medals, awards, etc. to the meritorious students of the Institute out of the corpus of the Alumni cell.
                        </li>
                        <li>
                            <i class="feather-check"></i> To arrange get together of the alumni and social/cultural functions of the alumni.
                        </li>
                        <li>
                            <i class="feather-check"></i> To honour distinguished alumni of PGIMER, who have brought national/global acclaim in their respective domains.
                        </li>
                        <li>
                            <i class="feather-check"></i> To mobilise and generate resources and funds to carry out the objectives of the Alumni Cell, accept donations and gifts of both movable and immovable assets.
                        
                    </ul>
               </div>
            </div>
        </div>
    </div>


@endsection
