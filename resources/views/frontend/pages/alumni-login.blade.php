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
            <div class="row g-5 align-items-center justify-content-center">
                <div class="col-lg-5">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">

                        <!-- ✅ 1. Error Messages Display -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- ✅ 2. Correct Form Action and CSRF Token -->
                        <form method="POST" action="{{ route('alumni-login.submit') }}">
                            @csrf
                           
                            <!-- ✅ 3. Correct Input Name: 'email' -->
                            <div class="form-group">
                                <input name="email" type="email" value="{{ old('email') }}" required>
                                <label>Email</label>
                                <span class="focus-border"></span>
                            </div>

                            <!-- ✅ 4. Correct Input Name: 'password' -->
                            <div class="form-group">
                                <input type="password" name="password" id="password" required>
                                <label>Password</label>
                                <span class="focus-border"></span>
                            </div>
                          
                            <div class="form-submit-group">
                                <button name="submit" type="submit" id="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Login</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>

                            <div class="form-group mt--40 text-center">
                                <a href="#">Forgot Password?</a>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    Don't have an account? <a href="{{ route('registration-new') }}" class="text-primary fw-bold">Register Here</a>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
