@extends('frontend.layout.master')
@section('title', 'Membership | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Membership</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Membership</li>
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

                    <h3 class="mb-4 text-center">TERMS OF ADMISSION OF THE MEMBERS</h3>
                    <hr>

                    <h5 class="mb-4">(1) ELIGIBLITY FOR MEMBERSHIP</h5>

                    <ul class="plan-offer-list rbt-list-primary-opacity mt-5">
                        <li>
                            <i class="feather-check"></i>
                            <strong>(a)</strong>
                            Those who have completed any Postgraduate medical course from PGIMER
                            (MD, MS, PhD, Fellowships, MSc, DM, MCh, MHA, MDS)
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            <strong>(b)</strong>
                            Faculty of PGIMER (Past and Present- at least 3 years regular service at
                            PGIMER, Chandigarh)
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            <strong>(c)</strong>
                            All those who have completed an undergraduate or Postgraduate paramedical
                            degree/diploma course at PGIMER (e.g. BSc &amp; MSc Nursing, BSc-MLT,
                            MSc-MLT BSc Speech and audiology, Perfusionist, Bachelor’s in Physiotherapy
                            and all other new paramedical courses of at least 3 years duration)
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            <strong>(d)</strong>
                            Anyone who has worked for at least 3 years in an academic medical job at PGIMER.
                        </li>
                    </ul>

                    <h5 class="mb-4 mt-5">2. MEMBERSHIP FEES:</h5>

                    <p>
                        Currently: – Indian Rs. 500 for Indian Residents and for residents of other
                        SAARC countries. $ 25 for all others
                    </p>

                    <h5 class="mb-4 mt-5">
                        3. RESIGNATION, FINES, EXPLUSION OF MEMBERS AND OFFICE BEARERS
                    </h5>

                    <ul class="plan-offer-list rbt-list-primary-opacity mt-5">
                        <li>
                            <i class="feather-check"></i>
                            On the death of a member
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            Resignation by the member
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            By the General Body on the recommendations of the Executive Committee
                            on the grounds of bringing disrepute to the Association by a member in
                            any way. On his/her involvement in antisociety activities, which are in
                            contravention to the constitution of the society.
                        </li>
                    </ul>

                    <h5 class="mb-4 mt-5">4 CATEGORIES OF MEMBERS:</h5>

                    <p>
                        There will be two categories of members in the above noted Society but all
                        the members shall be life members.
                    </p>

                    <ul class="plan-offer-list rbt-list-primary-opacity mt-5">
                        <li>
                            <i class="feather-check"></i>
                            <strong>(i) HONORARY MEMBER</strong>
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            <strong>(II) ORDINARY MEMBERS.</strong>
                        </li>
                    </ul>

                    <h5 class="mb-4 mt-5">i) Honorary Members:</h5>

                    <ul class="plan-offer-list rbt-list-primary-opacity mt-5">
                        <li>
                            <i class="feather-check"></i>
                            <strong>a)</strong>
                            The serving Director of PGIMER will be the Chief Patron of PCAAS.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            <strong>b)</strong>
                            All former Directors of the PGIMER, Chandigarh will be the Patrons of the Association.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            <strong>c)</strong>
                            All former Deans of the PGIMER, Chandigarh will be the advisors of the Association
                        </li>
                    </ul>

                    <h5 class="mb-4 mt-5">ii) ORDINARY MEMBERS:</h5>

                    <p>
                        Anyone who fulfil the qualifications as mentioned at Sr.No.1, can become
                        the member of the society, but he/she should be either recommended by one
                        of the Member of the Executive body or two members of General body of the
                        society by paying the one LIFE TIME membership fee, which is as follow:
                    </p>

                    <p>
                        Indian Rs. 500 for Indian Residents and for residents of other SAARC countries.
                        $ 25 for all others
                    </p>

                    <h5 class="mb-4 mt-5">FORMATION OF GENERAL BODY OF THE ASSOCIATION:</h5>

                    <h5 class="mb-4 mt-5">4.1. Composition:</h5>

                    <p>
                        All members of PCAAS whose names are on “register of Membership" of PCAAS
                        shall be members of the general Body of PCAAS.
                    </p>

                    <p>
                        The register of membership will be maintained and kept in the head office
                        of the Association.
                    </p>

                    <h5 class="mb-4 mt-5">
                        4.2. Voting rights and other privileges of members of the General Body
                    </h5>

                    <p>
                        All members of the Association are entitled to the same kind of privileges
                        except the voting rights which differ for various groups as under:
                    </p>

                    <p>
                        * All members of groups I (a) &amp; I (b), have voting rights on all issues
                        of the Association (e.g. election of the office bearers of the Association
                        as well as nominees of group B (only) on the Executive Committee, constitutional
                        amendments etc). Whereas, members of groups I(c) &amp; I (d) have voting right
                        only to elect nominees of their respective groups to the Executive Committee
                        of the Association.
                    </p>

                    <h5 class="mb-4 mt-5">
                        4.3 POWERS, FUNCTIONS AND DUTIES OF THE GENERAL BODY.
                    </h5>

                    <ul class="plan-offer-list rbt-list-primary-opacity mt-5">
                        <li>
                            <i class="feather-check"></i>
                            To elect the Executive Committee as per details in clause 6.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            To guide and examine the work of the Executive Committee and decide the
                            future line of action.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            To draw rules and byelaws for the smooth functioning of the Association.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            To examine and approve the yearly income and expenditure drawn by the
                            Executive Committee.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            To assist in raising funds for the Association.
                        </li>

                        <li>
                            <i class="feather-check"></i>
                            The General Body has the power to sanction extraordinary expenses of the
                            Association as and when deemed necessary. The General Body shall have the
                            supreme power and can change the decision of the Executive body but with
                            2/3rd Majority of the members present in such meeting the notice of which
                            shall not be less than 15 days.
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>



@endsection
