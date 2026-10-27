@extends('frontend.layout.master')
@section('title', 'About Us | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">About Us</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">About Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->


    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container-fluid">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                   <img src="assets/images/about/about-us.jpg" alt="">
                </div>
                <div class="col-lg-6">
                    <div class="inner pl--50 pl_sm--0 pl_md--0">
                        <div class="section-title text-start">
                           
                            <h2 class="title">PGI Alumni Relation Portal</h2>
                        </div>
                        <p align="justify" class="description mt--30">The PGIMER, Chandigarh was the vision of late Sardar Partap Singh Kairon, the Chief Minister of undivided Punjab and the distinguished medical educationists of the state of Punjab. This institute was started in 1962 and finally inaugurated by Pt Jawahar Lal Nehru, the first Prime Minister of India on 7th July 1963 to provide high quality patient care in the country and attain self sufficiency in postgraduate medical education to meet the country’s need for highly qualified medical teachers in all medical and surgical fields. The Institute was originally under the Government of undivided Punjab. After the reorganization of the state, the administrative control of the institute passed on to the Union Territory of Chandigarh in November 1966. The Institute became an autonomous body under the Act of Parliament in 1967 functioning under the Ministry of Health and Family Welfare, Government of India.</p>
                        <p align="justify"  class="description mt--30">In the finest global tradition of the reputed seats of learning, which cherish links with their former students for mutual pride and enrichment, PGIMER decided to create a PGI Alumni Relations Cell.</p>
                        
                      
                       
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
