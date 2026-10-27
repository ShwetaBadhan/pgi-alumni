@extends('frontend.layout.master')
@section('title', 'Alumni Login | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Alumni Login</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Alumni Login</li>
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
                <div class="col-lg-4 offset-lg-4">
                  <div class="rbt-contact-form contact-form-style-1 max-width-auto">

                     
                        <form id="contact-form" method="POST" action=""
                            class="rainbow-dynamic-form max-width-auto">
                           
                            <div class="form-group">
                                <input name="contact-phone" type="email">
                                <label>Email</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" id="subject" name="subject">
                                <label>Password</label>
                                <span class="focus-border"></span>
                            </div>
                          
                            <div class="form-submit-group">
                                <button name="submit" type="submit" id="submit"
                                    class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Submit</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                             <div class="form-group mt--40 text-center">
                              
                              <a href="">Forgot Password?</a>
                               
                            </div>
                        </form>
                    </div>
                </div>
               
            </div>
        </div>
    </div>


@endsection
