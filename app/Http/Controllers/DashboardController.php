<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniRegistration; // ✅ Model import karein

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ Total Registrations count
        $totalRegistrations = AlumniRegistration::count();

        // ✅ Paid / Approved Users count
        $paidUsers = AlumniRegistration::where('status', 'approved')->count();

        // ✅ Unpaid / Pending Users count (pending, payment_pending, payment_failed)
        $unpaidUsers = AlumniRegistration::whereIn('status', ['pending', 'payment_pending', 'payment_failed'])->count();

        return view('backend.pages.dashboard', compact(
            'totalRegistrations',
            'paidUsers',
            'unpaidUsers'
        ));
    }
}