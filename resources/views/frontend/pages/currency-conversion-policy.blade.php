@extends('frontend.layout.master')
@section('title', 'Currency Conversion Policy | PGI Alumni')
@section('content')


    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Currency Conversion Policy</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Currency Conversion Policy</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->


    <!-- Start Currency Conversion Rate Area -->
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">

                    <h3 class="mb-4">Currency Conversion Rate</h3>

                    <div class="alert alert-info mb-4" role="alert">
                        <strong>Attention Users:</strong>
                        <p class="mb-0 mt-2">
                            All transactions on our website in currencies other than
                            <strong>Indian Rupees (INR)</strong> will be charged in
                            <strong>United States Dollars (USD)</strong>.
                        </p>
                    </div>

                    <div class="rbt-feature-box rbt-feature-box-1 bg-color-light p-4 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-2">Current Conversion Rate</h4>
                                <p class="mb-0">
                                    <strong>1 USD = 101.1 INR</strong>
                                </p>
                            </div>

                            <div class="col-md-6 mt_md--20">
                                <p class="mb-1">
                                    <strong>Last Updated:</strong>
                                    9/29/2026, 5:30:01 AM
                                </p>

                                <p class="mb-0">
                                    <strong>Note:</strong>
                                    The conversion rate shown here is updated once every
                                    24 hours.
                                </p>
                            </div>
                        </div>
                    </div>


                    <!-- Currency Conversion Rate Disclaimer -->
                    <h3 class="mt-5 mb-4">
                        Currency Conversion Rate Disclaimer
                    </h3>

                    <p>
                        The currency conversion rates provided on this website for converting
                        <strong>United States Dollars (USD)</strong> to
                        <strong>Indian Rupees (INR)</strong> are for
                        <strong>informational purposes only</strong>.
                    </p>

                    <p>
                        These rates are based on the current market conditions and
                        <strong>may fluctuate</strong>.
                    </p>


                    <!-- Disclaimer -->
                    <h4 class="mt-5 mb-3">Disclaimer</h4>

                    <p>
                        The conversion rates provided are based on current market conditions
                        and may vary from the rates applied by financial institutions or
                        payment processors at the time of your transaction.
                    </p>

                    <p>
                        Factors such as exchange rate fluctuations, transaction fees, and
                        other charges may affect the actual conversion rate applied to
                        your transaction.
                    </p>

                    <p>
                        Users are advised to verify the conversion rates independently or
                        consult with a financial professional before making any financial
                        decisions based on the information provided on this website.
                    </p>

                    <p>
                        By using this website and relying on the currency conversion rates
                        provided herein, you agree that we shall not be liable for any loss
                        or damage arising from the use of or reliance on the information
                        provided.
                    </p>


                    <!-- Thank You -->
                    <div class="mt-5">
                        <p>
                            <strong>Thank you for your understanding.</strong>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Currency Conversion Rate Area -->







@endsection
