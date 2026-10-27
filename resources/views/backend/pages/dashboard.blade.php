@extends('backend.layouts.master')
@section('content')
<div class="dashboard-main-body">
    <div class="breadcrumb d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div>
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <p class="text-neutral-600 mt-4 mb-0">Manage your institute, track admissions, fees, and courses.</p>
        </div>
    </div>

    <div class="mt-24">
        <div class="row gy-4">
            <!-- Left Column: Stats Cards -->
            <div class="col-xxl-8">
                <div class="row gy-4">
                    <!-- Card 1: Total Students -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card shadow-1 radius-8 gradient-bg-end-1 h-100">
                            <div class="card-body p-20">
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                                    <div class="w-44-px h-44-px bg-warning-600 rounded-circle d-flex justify-content-center align-items-center">
                                        <i class="ri-user-line text-white fs-4"></i>
                                    </div>
                                    <p class="fw-medium text-primary-light mb-1">Total Students</p>
                                </div>
                                <h6 class="mb-0">{{ number_format($totalStudents) }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Total Courses -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card shadow-1 radius-8 gradient-bg-end-2 h-100">
                            <div class="card-body p-20">
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                                    <div class="w-44-px h-44-px bg-blue-600 rounded-circle d-flex justify-content-center align-items-center">
                                        <i class="ri-book-open-line text-white fs-4"></i>
                                    </div>
                                    <p class="fw-medium text-primary-light mb-1">Total Courses</p>
                                </div>
                                <h6 class="mb-0">{{ number_format($totalCourses) }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Active Students -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card shadow-1 radius-8 gradient-bg-end-3 h-100">
                            <div class="card-body p-20">
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                                    <div class="w-44-px h-44-px bg-purple-600 rounded-circle d-flex justify-content-center align-items-center">
                                        <i class="ri-user-check-line text-white fs-4"></i>
                                    </div>
                                    <p class="fw-medium text-primary-light mb-1">Active Students</p>
                                </div>
                                <h6 class="mb-0">{{ number_format($activeStudents) }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Paid Students -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card shadow-1 radius-8 gradient-bg-end-4 h-100">
                            <div class="card-body p-20">
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                                    <div class="w-44-px h-44-px bg-primary-600 rounded-circle d-flex justify-content-center align-items-center">
                                        <i class="ri-money-rupee-circle-line text-white fs-4"></i>
                                    </div>
                                    <p class="fw-medium text-primary-light mb-1">Fees Paid</p>
                                </div>
                                <h6 class="mb-0">{{ number_format($paidStudents) }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Pending Fees -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card shadow-1 radius-8 gradient-bg-end-5 h-100">
                            <div class="card-body p-20">
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                                    <div class="w-44-px h-44-px bg-success-600 rounded-circle d-flex justify-content-center align-items-center">
                                        <i class="ri-hourglass-line text-white fs-4"></i>
                                    </div>
                                    <p class="fw-medium text-primary-light mb-1">Fees Pending</p>
                                </div>
                                <h6 class="mb-0">{{ number_format($pendingStudents) }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6: Total Results -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card shadow-1 radius-8 gradient-bg-end-6 h-100">
                            <div class="card-body p-20">
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-16">
                                    <div class="w-44-px h-44-px bg-cyan-600 rounded-circle d-flex justify-content-center align-items-center">
                                        <i class="ri-award-line text-white fs-4"></i>
                                    </div>
                                    <p class="fw-medium text-primary-light mb-1">Results Generated</p>
                                </div>
                                <h6 class="mb-0">{{ number_format($totalResults) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Course Stats Chart -->
            <div class="col-xxl-4 col-lg-6">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-20 py-16 border-bottom border-neutral-200">
                            <h6 class="text-lg mb-0">Course Admissions</h6>
                        </div>
                        <div class="p-20">
                            <div class="position-relative text-center">
                                <!-- Chart Placeholder (You can integrate ApexCharts here later) -->
                                <div class="text-center position-absolute top-50 start-50 translate-middle">
                                    <h5 class="mb-4">{{ $totalStudents }}</h5>
                                    <span class="text-secondary-light">Total Admissions</span>
                                </div>
                            </div>
                            
                            <!-- Dynamic Course List -->
                            <ul class="d-flex flex-wrap align-items-center justify-content-center mt-48 gap-24">
                                @php $colors = ['bg-success-600', 'bg-blue-600', 'bg-warning-600', 'bg-primary-600']; @endphp
                                @foreach($courseStats as $index => $stat)
                                    <li class="d-flex align-items-center gap-2">
                                        <span class="w-12-px h-12-px radius-2 {{ $colors[$index % 4] }} rotate-45-deg"></span>
                                        <div class="">
                                            <span class="text-secondary-light fw-medium">
                                                {{ $stat->course }}: 
                                                <span class="fw-bold text-primary-light">{{ $stat->total }}</span>
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Column: Latest Students -->
            <div class="col-xxl-4">
                <div class="card radius-12 border-0 h-100">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between py-12 px-20 border-bottom border-neutral-200">
                        <h6 class="mb-2 fw-bold text-lg">Recent Admissions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-28">
                            @foreach($latestStudents as $student)
                                <div class="d-flex align-items-center justify-content-between gap-10">
                                    <div class="d-flex align-items-center gap-12">
                                        <span class="w-44-px h-44-px rounded-circle d-flex justify-content-center align-items-center bg-light">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" class="w-44-px h-44-px object-fit-cover rounded-circle" alt="Icon">
                                            @else
                                                <i class="ri-user-line fs-4 text-secondary-light"></i>
                                            @endif
                                        </span>
                                        <div class="">
                                            <h6 class="text-sm mb-2">{{ $student->name }}</h6>
                                            <span class="text-xs text-secondary-light">{{ $student->course }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-8">
                                        <span class="text-sm text-secondary-light">Roll No</span>
                                        <span class="text-primary-light text-sm d-block text-end fw-bold">
                                            {{ $student->roll_number }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($latestStudents->isEmpty())
                                <p class="text-center text-muted">No students found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection