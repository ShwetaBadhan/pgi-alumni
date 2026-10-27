@extends('frontend.layout.master')
@section('title', 'New Registration | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">New Registration</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">New Registration</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->



    <div class="alumni-registration-page">
        <div class="container-fluid">

            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">

                        <form id="alumni-registration-form" method="POST" action="" class="alumni-registration-form">

                            <!-- Form Title -->
                            <div class="form-group">
                                <h4 class="title">Alumni Registration Form</h4>
                            </div>


                            <div class="rbt-modern-select bg-transparent height-45 mb--20">
                                <select class="w-100" name="title" required>
                                    <option value="">Select Title</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="first_name" required>
                                        <label>First Name *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="middle_name">
                                        <label>Middle Name</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="last_name" required>
                                        <label>Last Name *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Date of Birth -->
                            <div class="form-group">
                                <input type="date" name="date_of_birth" required>
                                <label>Date of Birth *</label>
                                <span class="focus-border"></span>
                            </div>

                            <!-- Contact Numbers -->
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="tel" name="contact_number" required>
                                        <label>Contact Number *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="tel" name="whatsapp_number">
                                        <label>WhatsApp Enabled Contact Number</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Academic Information -->
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="passing_year">
                                        <label>Select Year of Passing Latest Degree from PGIMER</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="joining_year">
                                        <label>Select Year of Joining PGIMER as Faculty/Senior Resident</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-lg-6">

                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="title" required>
                                            <option value="">Select Any Degree Completed from PGIMER</option>
                                            <option value="MBBS">MBBS</option>
                                            <option value="MD">MD</option>
                                            <option value="MS">MS</option>
                                            <option value="DM">DM</option>
                                            <option value="M.Ch">M.Ch</option>
                                            <option value="PhD">PhD</option>
                                            <option value="Other">Other</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="title" required>
                                            <option value="">Select Department You Were Related To PGIMER *</option>
                                            <option value="Surgical Gastroenterology">
                                                Surgical Gastroenterology
                                            </option>
                                            <option value="Cardiology">Cardiology</option>
                                            <option value="Neurology">Neurology</option>
                                            <option value="Orthopaedics">Orthopaedics</option>
                                            <option value="General Medicine">General Medicine</option>
                                            <option value="Other">Other</option>
                                        </select>

                                    </div>
                                </div>

                            </div>

                            <!-- Email & Country -->
                            <div class="row">

                                <div class="col-lg-6 mt--20">
                                    <div class="form-group">
                                        <input type="email" name="email" required>
                                        <label>Email ID *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mt--45">

                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100" name="title" required>
                                            <option value="">Residence Country *</option>
                                            <option value="India">India</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Canada">Canada</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="Other">Other</option>
                                        </select>

                                    </div>
                                </div>

                            </div>

                            <!-- Password -->
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="password" id="password" name="password" minlength="12" required>
                                        <label>Create Password *</label>
                                        <span class="focus-border"></span>
                                    </div>

                                    <small>
                                        Use a strong password with at least 12 characters with
                                        uppercase, lowercase, numbers, and symbols.
                                    </small>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="password" id="confirm_password" name="confirm_password"
                                            minlength="12" required>
                                        <label>Confirm Password *</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Practice Information -->
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="practice_state">
                                        <label>The State That You Practice</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="practice_specialty">
                                        <label>Current Practice Specialty</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Registration Type -->
                            <div class="form-group mt--20">

                                <label class="static-label">
                                    Registration Type *
                                </label>

                                <div class="rbt-form-check">


                                    <input type="radio" class="form-check-input" name="rbt-radio  id="rbt-radio-1"
                                        value="Membership" required>
                                    <label class="form-check-label" for="rbt-radio-1">Membership</label>
                                </div>
                                <div class="rbt-form-check">
                                    <input type="radio" class="form-check-input" name="rbt-radio  id="rbt-radio-2"
                                        value="Membership + Global PGI Alumni Summit 2026">
                                    <label class="form-check-label" for="rbt-radio-2">Membership + Global PGI Alumni
                                        Summit 2026</label>
                                </div>


                                <div class="rbt-form-check">
                                    <input type="radio" class="form-check-input" name="rbt-radio  id="rbt-radio-3"
                                        value="Membership + PG students">
                                    <label class="form-check-label" for="rbt-radio-3">Membership + PG students</label>
                                </div>



                            </div>

                    </div>

                    <!-- Documentary Proof -->
                    <div class="form-group">

                        <label class="static-label">
                            Upload Documentary Proof for Your Association as Alumni with PGI
                        </label>

                        <input type="file" name="documentary_proof" accept=".pdf,.jpg,.jpeg,.png">

                    </div>

                    <!-- Contribution -->
                    <div class="form-group">

                        <label class="static-label  mt--200">
                            Please support the PGI Alumni Society well-being through
                            meaningful and valuable contributions
                        </label>

                        <div class="radio-group">

                            <label>
                                <input type="radio" name="contribution" value="5000">
                                INR 5,000.00
                            </label>

                            <label>
                                <input type="radio" name="contribution" value="10000">
                                INR 10,000.00
                            </label>

                            <label>
                                <input type="radio" name="contribution" value="50000">
                                INR 50,000.00
                            </label>

                            <label>
                                <input type="radio" name="contribution" value="100000">
                                INR 100,000.00
                            </label>

                            <label>
                                <input type="radio" name="contribution" value="not_interested">
                                Not interested at this moment
                            </label>

                        </div>

                    </div>

                    <!-- Captcha -->
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="captcha" required>
                                <label>Enter Captcha Code</label>
                                <span class="focus-border"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="captcha-box">
                                <span class="captcha-refresh">↻</span>
                                <span class="captcha-code">47997</span>
                            </div>
                        </div>

                    </div>

                    <!-- Agreement -->
                    {{-- <div class="form-group mt--20">

                                <label class="checkbox-label">
                                    <input type="checkbox" name="agreement" required>
                                    I agree that all the above information is correct
                                    to the best of my knowledge
                                </label>

                            </div> --}}

                    <!-- Submit -->
                    <div class="form-submit-group">

                        <button name="submit" type="submit" id="submit"
                            class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">

                            <span class="icon-reverse-wrapper">

                                <span class="btn-text">
                                    Submit
                                </span>

                                <span class="btn-icon">
                                    <i class="feather-arrow-right"></i>
                                </span>

                                <span class="btn-icon">
                                    <i class="feather-arrow-right"></i>
                                </span>

                            </span>

                        </button>

                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
    </div>


@endsection
