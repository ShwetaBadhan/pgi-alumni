@extends('frontend.layout.master')
@section('title', 'Hotels Accommodations | PGI Alumni')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Hotels Accommodations</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Hotels Accommodations</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <!-- ================================
         Hotels & Accommodations
    ================================ -->

    <style>
        .hotel-page-area {
            background: #f7f9fb;
            padding: 90px 0;
        }

        .hotel-page-heading {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 55px;
        }

        .hotel-page-heading .subtitle {
            display: inline-block;
            color: #0d6efd;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
        }

        .hotel-page-heading h2 {
            font-size: 42px;
            line-height: 1.2;
            margin-bottom: 15px;
            color: #172b4d;
        }

        .hotel-page-heading p {
            color: #6b7280;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 0;
        }

        .hotel-card {
            background: #fff;
            border: 1px solid #e8edf2;
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
            transition: all 0.35s ease;
            box-shadow: 0 8px 30px rgba(20, 40, 70, 0.05);
        }

        .hotel-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 45px rgba(20, 40, 70, 0.12);
            border-color: rgba(13, 110, 253, 0.15);
        }

        .hotel-image {
            height: 230px;
            position: relative;
            overflow: hidden;
            background: #eef3f7;
        }

        .hotel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .hotel-card:hover .hotel-image img {
            transform: scale(1.05);
        }

        .hotel-distance {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: #172b4d;
            padding: 7px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .hotel-content {
            padding: 25px;
        }

        .hotel-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 14px;
        }

        .hotel-title-row h3 {
            font-size: 23px;
            line-height: 1.3;
            margin: 0;
            color: #172b4d;
        }

        .hotel-location-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
            border-radius: 50%;
            background: #eef6ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hotel-contact {
            background: #f7f9fb;
            border-radius: 10px;
            padding: 13px 15px;
            margin-bottom: 20px;
        }

        .hotel-contact-item {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #687588;
            font-size: 13px;
            line-height: 1.5;
        }

        .hotel-contact-item+.hotel-contact-item {
            margin-top: 7px;
        }

        .hotel-contact-item i {
            color: #0d6efd;
            font-size: 14px;
        }

        .hotel-contact-item a {
            color: #687588;
        }

        .hotel-contact-item a:hover {
            color: #0d6efd;
        }

        .hotel-rates-title {
            font-size: 14px;
            font-weight: 700;
            color: #172b4d;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #edf0f3;
        }

        .hotel-rate-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 9px 0;
            border-bottom: 1px dashed #e4e8ec;
        }

        .hotel-rate-row:last-child {
            border-bottom: 0;
        }

        .hotel-room-name {
            color: #566274;
            font-size: 13px;
            font-weight: 600;
        }

        .hotel-price {
            text-align: right;
            color: #172b4d;
            font-size: 13px;
            font-weight: 700;
        }

        .hotel-price span {
            display: block;
            color: #7a8594;
            font-size: 11px;
            font-weight: 500;
            margin-top: 2px;
        }

        .hotel-suite-note {
            color: #566274;
            font-size: 13px;
            padding: 8px 0;
        }

        .hotel-suite-note strong {
            color: #172b4d;
        }

        .hotel-footer {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #edf0f3;
        }

        .hotel-book-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 8px;
            background: #0d6efd;
            color: #fff !important;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .hotel-book-btn:hover {
            background: #0958c7;
            color: #fff;
        }

        .hotel-contact-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 8px;
            background: #f0f5fa;
            color: #172b4d !important;
            font-size: 14px;
            font-weight: 700;
        }

        .hotel-note {
            margin-top: 45px;
            padding: 18px 22px;
            border-radius: 10px;
            background: #fff;
            border: 1px solid #e8edf2;
            color: #687588;
            font-size: 13px;
            line-height: 1.7;
        }

        .hotel-note strong {
            color: #172b4d;
        }

        @media (max-width: 991px) {
            .hotel-page-area {
                padding: 70px 0;
            }

            .hotel-page-heading h2 {
                font-size: 34px;
            }
        }

        @media (max-width: 575px) {
            .hotel-page-area {
                padding: 55px 0;
            }

            .hotel-page-heading {
                margin-bottom: 35px;
            }

            .hotel-page-heading h2 {
                font-size: 29px;
            }

            .hotel-image {
                height: 210px;
            }

            .hotel-content {
                padding: 20px;
            }
        }
    </style>


    <section class="hotel-page-area">

        <div class="container">

            <!-- Page Heading -->
            <div class="hotel-page-heading">


                <h2>Accommodations To Stay</h2>


            </div>


            <div class="row g-4">


                <!-- Mountview -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/mountainview.jpg" alt="Mountview Hotel" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 1.4 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Mountview</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Mr. Malik</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:9988222280">
                                        99882 22280
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe Room
                                </div>

                                <div class="hotel-price">
                                    ₹4,875 / ₹5,250
                                    <span>Single / Double + Taxes</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Executive Room
                                </div>

                                <div class="hotel-price">
                                    ₹5,625 / ₹6,000
                                    <span>Single / Double + Taxes</span>
                                </div>
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Royal / Family Suite:</strong>
                                ₹10,500 + Taxes
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Extra Person:</strong>
                                ₹1,200
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Taj Chandigarh -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/taj.jpeg" alt="Taj Chandigarh" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 2.5 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Taj Chandigarh</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Contact details available on request</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:9115544200">
                                        91155 44200
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Superior Rooms
                                </div>

                                <div class="hotel-price">
                                    ₹8,400 / ₹9,440
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe Room
                                </div>

                                <div class="hotel-price">
                                    ₹10,030 / ₹10,620
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Taj Club
                                </div>

                                <div class="hotel-price">
                                    ₹18,880 / ₹19,470
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-footer">
                                <a href="https://www.tajhotels.com/en-in" target="_blank" rel="noopener"
                                    class="hotel-book-btn">
                                    Book Now
                                    <i class="feather-arrow-up-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Shivalik View -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/shivalik.jpg" alt="Shivalik View" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 3.4 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Shivalik View</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Mr. Kulwinder</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:9876721357">
                                        98767 21357
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Standard Rooms
                                </div>

                                <div class="hotel-price">
                                    ₹3,528 / ₹3,948
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe Rooms
                                </div>

                                <div class="hotel-price">
                                    ₹4,452 / ₹4,956
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Extra Person:</strong> ₹1,344
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Hyatt Centric -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/hyatt.jpeg" alt="Hyatt Centric" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 3.6 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Hyatt Centric</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Mr. Navtej Singh</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:7347017656">
                                        73470 17656
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Hyatt King
                                </div>

                                <div class="hotel-price">
                                    ₹10,030 / ₹10,620
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe
                                </div>

                                <div class="hotel-price">
                                    ₹11,800 / ₹12,390
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Premium Room
                                </div>

                                <div class="hotel-price">
                                    ₹16,520 / ₹17,110
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Centric Suite:</strong> ₹37,760
                            </div>

                            <div class="hotel-footer">
                                <a href="https://www.hyatt.com/en-US/group-booking/IXCCT/G-PGII" target="_blank"
                                    rel="noopener" class="hotel-book-btn">
                                    Book Now
                                    <i class="feather-arrow-up-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Park View -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/park.jpg" alt="Park View Hotel" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 3.6 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Park View</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Mr. Narang</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:9814630675">
                                        98146 30675
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Semi-Deluxe Room
                                </div>

                                <div class="hotel-price">
                                    ₹1,980
                                    <span>Double Occupancy</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe Room
                                </div>

                                <div class="hotel-price">
                                    ₹2,550
                                    <span>Double Occupancy</span>
                                </div>
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Extra Bed:</strong> ₹600
                            </div>

                        </div>
                    </div>
                </div>


                <!-- JW Marriott -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/jw.jpg" alt="JW Marriott Chandigarh" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 6.0 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>JW Marriott</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Ms. Sakshi Mishra</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:7508180046">
                                        75081 80046
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe
                                </div>

                                <div class="hotel-price">
                                    ₹12,390 / ₹12,980
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Executive
                                </div>

                                <div class="hotel-price">
                                    ₹14,750 / ₹15,340
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Studio
                                </div>

                                <div class="hotel-price">
                                    ₹32,450 / ₹33,040
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Luxury
                                </div>

                                <div class="hotel-price">
                                    ₹46,610 / ₹47,200
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-footer">
                                <a href="https://www.marriott.com/https://www.marriott.com/event-reservations/reservation-link.mi?id=1715345737933&key=GRP&app=resvlink"
                                    target="_blank" rel="noopener" class="hotel-book-btn">
                                    Book Now
                                    <i class="feather-arrow-up-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- The Aroma -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/aroma.jpg" alt="The Aroma Hotel" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 6.3 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>The Aroma</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:9914428844">
                                        99144 28844
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Classic
                                </div>

                                <div class="hotel-price">
                                    ₹3,000 / ₹3,500
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Aquamarine
                                </div>

                                <div class="hotel-price">
                                    ₹3,600 / ₹4,200
                                    <span>Single / Double</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Lemon Tree -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/lemon-tree.jpg" alt="Lemon Tree Hotel" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 8.1 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Lemon Tree</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Mr. Ashish</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:6205537162">
                                        62055 37162
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Business Room
                                </div>

                                <div class="hotel-price">
                                    ₹6,944 / ₹7,504
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Executive Room
                                </div>

                                <div class="hotel-price">
                                    ₹7,944 / ₹8,504
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Royal / Family Suite:</strong> ₹10,500
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Extra Person:</strong> ₹1,200
                            </div>

                        </div>
                    </div>
                </div>


                <!-- The Lalit -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/lalit.jpg" alt="The Lalit Hotel" loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 8.4 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>The Lalit</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Mr. Ashish</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:8288033990">
                                        82880 33990
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Deluxe Room
                                </div>

                                <div class="hotel-price">
                                    ₹7,670 / ₹8,260
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Premier Room
                                </div>

                                <div class="hotel-price">
                                    ₹8,850 / ₹9,440
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Luxury Room
                                </div>

                                <div class="hotel-price">
                                    ₹14,160 / ₹14,750
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-suite-note">
                                <strong>Luxury Suite:</strong>
                                ₹35,400 / ₹35,990
                                <small>Single / Double</small>
                            </div>

                            <div class="hotel-footer">
                                <a href="https://be.synxis.com/?Hotel=76440&Chain=21542&arrive=2024-10-21&depart=2024-10-22&adult=1&child=0&group=PGI201024"
                                    target="_blank" rel="noopener" class="hotel-book-btn">
                                    Book Now
                                    <i class="feather-arrow-up-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Hyatt Regency -->
                <div class="col-lg-4 col-md-6">
                    <div class="hotel-card">

                        <div class="hotel-image">
                            <img src="assets/images/accommodations/hyatt-regency.jpg" alt="Hyatt Regency Chandigarh"
                                loading="lazy">

                            <span class="hotel-distance">
                                <i class="feather-map-pin"></i> 9.4 Km
                            </span>
                        </div>

                        <div class="hotel-content">

                            <div class="hotel-title-row">
                                <h3>Hyatt Regency</h3>

                                <div class="hotel-location-icon">
                                    <i class="feather-home"></i>
                                </div>
                            </div>

                            <div class="hotel-contact">

                                <div class="hotel-contact-item">
                                    <i class="feather-user"></i>
                                    <span>Ms. Taranjeet Kaur</span>
                                </div>

                                <div class="hotel-contact-item">
                                    <i class="feather-phone"></i>
                                    <a href="tel:7087033592">
                                        70870 33592
                                    </a>
                                </div>

                            </div>

                            <div class="hotel-rates-title">
                                Room Rates
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    King Room
                                </div>

                                <div class="hotel-price">
                                    ₹11,800 / ₹12,390
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Hyatt King View
                                </div>

                                <div class="hotel-price">
                                    ₹12,390 / ₹12,980
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-rate-row">
                                <div class="hotel-room-name">
                                    Club King Room
                                </div>

                                <div class="hotel-price">
                                    ₹15,340 / ₹15,930
                                    <span>Single / Double</span>
                                </div>
                            </div>

                            <div class="hotel-footer">
                                <a href="https://www.hyatt.com/" target="_blank" rel="noopener" class="hotel-book-btn">
                                    Book Now
                                    <i class="feather-arrow-up-right"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


        
        </div>

    </section>




@endsection
