<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('backend.pages.dashboard', [
            'totalStudents'   => 0,
            'totalCourses'    => 0,
            'activeStudents'  => 0,
            'paidStudents'    => 0,
            'pendingStudents' => 0,
            'totalResults'    => 0,
            'courseStats'     => collect(), // Empty collection
            'latestStudents'  => collect(), // Empty collection
        ]);
    }
}