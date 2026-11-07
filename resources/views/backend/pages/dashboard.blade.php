@extends('backend.layouts.master')

@section('content')
<div class="dashboard-main-body">
    <!-- Start Page Header -->
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div>
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <p class="text-neutral-600 mt-4 mb-0">Overview of Alumni Registrations and Payment Status.</p>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Start Stats Cards -->
    <div class="mt-24">
        <div class="row gy-4">
            
            {{-- Card 1: Total Registrations --}}
            <div class="col-xl-4 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-blue-600 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="ri-group-line text-white fs-4"></i>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Total Registrations</p>
                        </div>
                        <h6 class="mb-0">{{ number_format($totalRegistrations) }}</h6>
                    </div>
                </div>
            </div>

            {{-- Card 2: Paid / Approved Users --}}
            <div class="col-xl-4 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-success-600 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="ri-money-rupee-circle-line text-white fs-4"></i>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Paid / Approved Users</p>
                        </div>
                        <h6 class="mb-0">{{ number_format($paidUsers) }}</h6>
                    </div>
                </div>
            </div>

            {{-- Card 3: Unpaid / Pending Users --}}
            <div class="col-xl-4 col-sm-6">
                <div class="card shadow-1 radius-8 gradient-bg-end-5 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                            <div class="w-44-px h-44-px bg-warning-600 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="ri-hourglass-line text-white fs-4"></i>
                            </div>
                            <p class="fw-medium text-primary-light mb-1">Unpaid / Pending Users</p>
                        </div>
                        <h6 class="mb-0">{{ number_format($unpaidUsers) }}</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Stats Cards -->
    
</div>
@endsection