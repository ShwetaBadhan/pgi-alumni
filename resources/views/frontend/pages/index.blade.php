@extends('frontend.layout.master')
@section('title', 'Home | PGI Alumni')
@section('content')


    <!-- Start Banner Area  -->
    <div class="rbt-banner-area rbt-banner-19">
        <div class="wrapper">
            <div class="swiper rbt-banner-activation-2 rbt-slider-animation rbt-arrow-between">
                <div class="swiper-wrapper">
                    <!-- Start Single Banner  -->
                    <div class="swiper-slide">
                        <div class="rbt-banner-item bg_image">
                            {{-- <div class="shape-1">
                                <img src="assets/images/shape/m-banner-shape-01.png" alt="Shape">
                            </div> --}}
                            <img src="assets/images/banner/pgi-slider.jpg" alt="" style="width:1355px;">
                        </div>
                    </div>
                    <!-- End Single Banner  -->


                </div>

                <div class="rbt-slider-control">
                    <div class="rbt-swiper-arrow-2 rbt-arrow-left">
                        <span class="icon">
                            <i class="rbt-icon-top feather-arrow-left"></i>
                        </span>
                        <span class="text">Prev</span>
                    </div>

                    <div class="rbt-swiper-arrow-2 rbt-arrow-right">
                        <span class="text">
                            Next
                        </span>
                        <span class="icon">
                            <i class="rbt-icon feather-arrow-right"></i>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Banner Area  -->


    <div class="rbt-split-area bg-color-white overflow-hidden rbt-section-gapTop">
        <div class="wrapper">
            <div class="rbt-splite-style">
                <div class="split-wrapper">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-12 col-xl-6 col-12">
                            <div class="thumbnail image-left-content">
                                <img src="assets/images/about/about-us.jpg" alt="split Images">
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6 col-12">
                            <div class="split-inner">

                                <h4 class="title sal-animate" data-sal="slide-up" data-sal-duration="400"
                                    data-sal-delay="200">About Us</h4>
                                <p align="justify" class="description sal-animate" data-sal="slide-up"
                                    data-sal-duration="400" data-sal-delay="300">
                                    The PGIMER, Chandigarh was the vision of late Sardar Partap Singh Kairon, the Chief
                                    Minister of undivided Punjab and the distinguished medical educationists of the state of
                                    Punjab. This institute was started in 1962 and finally inaugurated by Pt Jawahar Lal
                                    Nehru, the first Prime Minister of India on 7th July 1963 to provide high quality
                                    patient care in the country and attain self sufficiency in postgraduate medical
                                    education to meet the country’s need for highly qualified medical teachers in all
                                    medical and surgical fields. The Institute was originally under the Government of
                                    undivided Punjab.</p>
                                <div class="view-more-button mt--35 sal-animate" data-sal="slide-up" data-sal-duration="400"
                                    data-sal-delay="400">
                                    <a class="rbt-moderbt-btn" href="#">
                                        <span class="moderbt-btn-text">Read More</span>
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start Feature Area -->
    <div class="rbt-feature-area objectives-area bg-color-white rbt-section-gap">
        <div class="container">

            <!-- Section Heading -->
            <div class="row mb--50">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="section-subtitle">PCAAS</span>
                        <h2 class="title w-600">Objectives of Society</h2>
                        <div class="title-line"></div>
                    </div>
                </div>
            </div>

            <!-- Objectives -->
            <div class="row g-4">

                <!-- Objective 1 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="objective-card objective-blue">
                        <div class="objective-icon">
                            <i class="feather-users"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To promote interaction amongst members and to serve as a
                                link between the members of PCAAS and their Alma Mater
                                i.e. PGIMER Chandigarh, India.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

                <!-- Objective 2 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="objective-card objective-green">
                        <div class="objective-icon">
                            <i class="feather-heart"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To organise Welfare Services for its members, PGIMER
                                students, disaster management services and humanity
                                at large.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

                <!-- Objective 3 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="objective-card objective-purple">
                        <div class="objective-icon">
                            <i class="feather-hand"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To provide help and any other type of assistance
                                to the members of PCAAS.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

                <!-- Objective 4 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="objective-card objective-orange">
                        <div class="objective-icon">
                            <i class="feather-award"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To conduct academic activities and to award prizes
                                for excellent work done in the medical field
                                and/or social sphere.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

                <!-- Objective 5 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="objective-card objective-cyan">
                        <div class="objective-icon">
                            <i class="feather-book-open"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To publish or assist in the publication of PCAAS
                                newsletter, books and/or journals by members of PCAAS.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

                <!-- Objective 6 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="objective-card objective-pink">
                        <div class="objective-icon">
                            <i class="feather-plus-circle"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To work towards improvement of medical education
                                and health care services in the community.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

                <!-- Objective 7 -->
                <div class="col-12">
                    <div class="objective-card objective-wide objective-violet">

                        <div class="objective-icon">
                            <i class="feather-home"></i>
                        </div>

                        <div class="objective-content">
                            <p>
                                To organize medical camps in different parts of the
                                country to provide free counselling, medical care
                                and aid to the suffering poor and the downtrodden
                                without distinction of caste, creed and religion.
                            </p>
                        </div>

                        <span class="objective-line"></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Feature Area -->


    <!-- Start Blog Area -->
    <div class="rbt-rbt-blog-area rbt-section-gap">
        <div class="container">
            <div class="row mb--60 mb_sm--50 g-5 align-items-end">
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-primary-opacity">News & Blog</span>
                        <h2 class="title">Have a Look on <span class="theme-gradient">Our Update</span></h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn btn-gradient hover-icon-reverse" href="blog.html">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">View All Posts</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row g-5">
                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="assets/images/blog/blog-1.png" alt="Card image"> </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5><a href="course-details.html">Indian American Cancer Scientists Honored for Groundbreaking
                                    Discoveries</a></h5>
                            <p class="rbt-card-text">The Society of American Asian Scientists in Cancer Research is a
                                non-profit, non-political organization registered in the state of California in 2004 and has
                                more than 5,000 members </p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html">Read
                                    More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629"></path>
                                                <path stroke-linecap="square" d="M.663 5.572h14.594"></path>
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="assets/images/blog/blog-2.jpg" alt="Card image">
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Indian American Scientists Awarded
                                    for Cancer Research...</a></h5>
                            <p class="rbt-card-text">Eight Indian scientists were honored for their contributions in cancer
                                research by the Society of American Asian Scientists in Cancer Research (SAASCR) on May 17,
                                2021.</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html">Read
                                    More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629"></path>
                                                <path stroke-linecap="square" d="M.663 5.572h14.594"></path>
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="assets/images/blog/blog-3.jpg" alt="Card image"> </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">PM Modi Hai Toh Mumkin Hai</a></h5>
                            <p class="rbt-card-text">NEW DELHI: Under ‘Operation Kaveri’, 328 more Indians landed at the
                                New Delhi International Airport from strife-torn Sudan. Nearly 3,000 stranded Indians have
                                reached India till now. “328 more passengers have landed in…</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html">Read
                                    More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629"></path>
                                                <path stroke-linecap="square" d="M.663 5.572h14.594"></path>
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Blog Area -->


    <!-- Start Gallery Area -->
    <div class="rbt-gallery-area rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-12">
                    <div class="section-title text-center">

                        <h2 class="title w-600">Our Gallery</h2>
                    </div>
                </div>
            </div>
            <div class="row g-3 g-sm-4 g-md-5 parent-gallery-container">
                <a href="assets/images/gallery/gallery-1.png"
                    class="child-gallery-single col-lg-6 col-md-6 col-sm-8 col-12">
                    <div class="rbt-gallery">
                        <img class="w-100 radius-10" src="assets/images/gallery/gallery-1.jpg" alt="Gallery Images">
                    </div>
                </a>
                <a href="assets/images/gallery/gallery-2.jpg"
                    class="child-gallery-single col-lg-3 col-md-3 col-sm-4 col-6">
                    <div class="rbt-gallery">
                        <img class="w-100 radius-10" src="assets/images/gallery/gallery-2.jpg" alt="Gallery Images">
                    </div>
                </a>
                <a href="assets/images/gallery/gallery-3.jpg"
                    class="child-gallery-single col-lg-3 col-md-3 col-sm-4 col-6">
                    <div class="rbt-gallery">
                        <img class="w-100 radius-10" src="assets/images/gallery/gallery-3.jpg" alt="Gallery Images">
                    </div>
                </a>
                <a href="assets/images/gallery/gallery-4.jpg"
                    class="child-gallery-single col-lg-3 col-md-3 col-sm-4 col-6">
                    <div class="rbt-gallery">
                        <img class="w-100 radius-10" src="assets/images/gallery/gallery-4.jpg" alt="Gallery Images">
                    </div>
                </a>
                <a href="assets/images/gallery/gallery-5.jpg"
                    class="child-gallery-single col-lg-6 col-md-6 col-sm-4 col-6">
                    <div class="rbt-gallery">
                        <img class="w-100 radius-10" src="assets/images/gallery/gallery-5.jpg" alt="Gallery Images">
                    </div>
                </a>
                <a href="assets/images/gallery/gallery-6.jpg"
                    class="child-gallery-single col-lg-3 col-md-3 col-sm-4 col-6">
                    <div class="rbt-gallery">
                        <img class="w-100 radius-10" src="assets/images/gallery/gallery-6.jpg" alt="Gallery Images">
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- End Gallery Area -->

    <!-- Start Call To Action  -->
    <div class="rbt-callto-action-area rbt-section-gap">
        
        <div class="rbt-callto-action rbt-cta-default style-2">
            <div class="container content-wrapper overflow-hidden">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-8">
                        <div class="inner">
                            <div class="content text-left">
                                <h3 class="title" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">
                                    Global Newborn Society</h3>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="call-to-btn text-start text-lg-end position-relative" data-sal="slide-up"
                            data-sal-duration="400" data-sal-delay="400">
                            <a class="rbt-btn rbt-switch-btn rbt-switch-y" href="#">
                                <span data-text="Visit Now">Visit Now</span>
                            </a>
                            <div class="shape-text-image">
                                <img class="rbt-rotatation-round" src="assets/images/shape/cta-text.png"
                                    alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Call To Action  -->
@endsection
