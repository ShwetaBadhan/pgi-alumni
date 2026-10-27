<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Course;
use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // 1. Basic Counts
    $totalStudents = Student::count();
    $totalCourses = Course::count();
    $activeStudents = Student::where('status', true)->count();
    $paidStudents = Student::where('fee_status', 'paid')->count();
    $pendingStudents = Student::where('fee_status', '!=', 'paid')->count();
    $totalResults = Result::count();

    // 2. Course-wise Admissions (For Chart)
    $courseStats = Student::select('course', DB::raw('count(*) as total'))
        ->groupBy('course')
        ->orderByDesc('total')
        ->take(4) // Top 4 courses for the chart
        ->get();

    // 3. Latest Students (For Top Student / Recent Admissions List)
    $latestStudents = Student::latest()->take(5)->get();

    return view('backend.pages.dashboard', compact(
        'totalStudents', 'totalCourses', 'activeStudents', 
        'paidStudents', 'pendingStudents', 'totalResults',
        'courseStats', 'latestStudents'
    ));
}
}
