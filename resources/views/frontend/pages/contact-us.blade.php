@extends('frontend.layout.master')
@section('title', 'Contact Us | PGI Alumni')
@section('content')

    <div class="rbt-conatct-area bg-gradient-11 rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb--60">
                        <span class="subtitle bg-secondary-opacity">Contact Us</span>
                        <h2 class="title">PGI Alumni</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="150"
                    data-sal-duration="800">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-headphones"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Contact Phone Number</h4>
                            <p><a href="tel:01722756481">0172-2756481, 2756483</a></p>
                            <p><a href="tel:+918837845522">Whatsapp No.: 8837845522</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="200"
                    data-sal-duration="800">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-mail"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Our Email Address</h4>
                            <p><a href="/cdn-cgi/l/email-protection#79181d141017391e14181015571a1614"><span
                                        class="__cf_email__"
                                        data-cfemail="2746434a4e4967404a464e4b0944484a">pcaasixc@gmail.com</span></a></p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="250"
                    data-sal-duration="800">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-map-pin"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Our Location</h4>
                            <p>PGIMER, Sector-12, Chandigarh,
                                Pin- 160 012, India</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-contact-address">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="thumbnail">
                        <img class="w-100 radius-6" src="assets/images/about/pgi.jpg" alt="Contact Images">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">

                        <h3 class="title">Send Message</h3>
                        <form id="contact-form" method="POST" action="mail.php"
                            class="rainbow-dynamic-form max-width-auto">
                            <div class="form-group">
                                <input name="contact-name" id="contact-name" type="text">
                                <label>Name</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group">
                                <input name="contact-phone" type="email">
                                <label>Email</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="subject" name="subject">
                                <label>Your Subject</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group">
                                <textarea name="contact-message" id="contact-message"></textarea>
                                <label>Message</label>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-google-map bg-color-white rbt-section-gapTop">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3428.341322734365!2d76.7755589!3d30.764998400000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ff27f67661afb%3A0xad4389e0eee19a83!2sPost%20Graduate%20Institute%20of%20Medical%20Education%20%26%20Research%2C%20Chandigarh!5e0!3m2!1sen!2sin!4v1790660552456!5m2!1sen!2sin"
            width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>


@endsection
