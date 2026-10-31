<?php

namespace App\Http\Controllers;

use App\Models\AlumniRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\AccompanyingPersonRate;

class AlumniAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.pages.alumni-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = AlumniRegistration::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email is not registered.'])->onlyInput('email');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.'])->onlyInput('email');
        }

        // ✅ EXPLICITLY 'alumni' GUARD USE KAREIN
        Auth::guard('alumni')->login($user);
        $request->session()->regenerate();

        return redirect()->route('alumni.profile')->with('success', 'Login Successful! Welcome back.');
    }


    public function profile()
    {
        $user = Auth::guard('alumni')->user();
        if (!$user) {
            return redirect()->route('alumni-login')->with('error', 'Please login first.');
        }


        $accompanyingRate = AccompanyingPersonRate::where('status', true)->first();
        $user->load('accompanyingPersons');

        return view('frontend.pages.alumni-profile', compact('user', 'accompanyingRate'));
    }
    public function logout()
    {
        // ✅ 'alumni' guard se logout karein
        Auth::guard('alumni')->logout();
        $request = request();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    public function updateAccompanying(Request $request)
    {
        $user = Auth::guard('alumni')->user();

        // 1. Database  Active Rate Fetch 
        $rateConfig = AccompanyingPersonRate::where('status', true)->first();
        $baseCharge = $rateConfig ? $rateConfig->base_rate : 2000;
        $finalCharge = $baseCharge;

        $isAlumni = $request->has('accompanying_is_alumni') && !empty($request->accompanying_alumni_id);
        $wantsMembership = $request->has('accompanying_wants_membership');

        if ($isAlumni) {

            if ($rateConfig && $rateConfig->is_discount_enabled) {
                // ✅ PERCENTAGE CALCULATION
                $discountAmount = ($baseCharge * $rateConfig->discount_percentage) / 100;
                $finalCharge = $baseCharge - $discountAmount;
            } else {
                $finalCharge = $baseCharge;
            }
        } elseif ($wantsMembership) {

            $finalCharge = 500;
        }

        // Round off to 2 decimal places
        $finalCharge = round($finalCharge, 2);

        // 3. Database
        $user->accompanyingPerson()->updateOrCreate(
            ['registration_id' => $user->id],
            [
                'name' => $request->accompanying_name,
                'relation' => $request->accompanying_relation,
                'is_alumni' => $isAlumni,
                'alumni_membership_id' => $request->accompanying_alumni_id,
                'wants_membership' => $wantsMembership,
                'charge' => $finalCharge,
            ]
        );

        $discountText = ($isAlumni && $rateConfig && $rateConfig->is_discount_enabled)
            ? " ({$rateConfig->discount_percentage}% Discount Applied)"
            : "";

        return back()->with('success', 'Accompanying person details updated! Charge: ₹' . number_format($finalCharge, 2) . $discountText);
    }
    public function addAccompanyingPerson(Request $request)
    {
        $user = Auth::guard('alumni')->user();

        $validated = $request->validate([
            'belongs_to_pgi' => 'required|boolean',
            'has_membership' => 'nullable|boolean',
            'requires_membership' => 'nullable|boolean',
            'member_id' => 'nullable|string|max:255',
            'title' => 'required|string|max:10',
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|in:Male,Female,Other',
        ]);

        // Calculate charge
        $rateConfig = AccompanyingPersonRate::where('status', true)->first();
        $baseCharge = $rateConfig ? $rateConfig->base_rate : 5000;
        $finalCharge = $baseCharge;

        $isAlumni = $request->belongs_to_pgi == 1;
        $wantsMembership = $request->requires_membership == 1;

        // Apply discount logic
        if ($isAlumni) {
            if ($rateConfig && $rateConfig->is_discount_enabled) {
                $discountAmount = ($baseCharge * $rateConfig->discount_percentage) / 100;
                $finalCharge = $baseCharge - $discountAmount;
            }
        }

        // Create accompanying person
        $user->accompanyingPersons()->create([
            'name' => $request->full_name,
            'relation' => 'Accompanying Person',
            'is_alumni' => $isAlumni,
            'alumni_membership_id' => $request->member_id,
            'wants_membership' => $wantsMembership,
            'charge' => round($finalCharge, 2),
            'title' => $request->title,
        ]);

        return back()->with('success', 'Accompanying person added successfully! Charge: ₹' . number_format($finalCharge, 2));
    }

    public function deleteAccompanyingPerson($id)
    {
        $user = Auth::guard('alumni')->user();


        $person = $user->accompanyingPersons()->findOrFail($id);
        $person->delete();

        return back()->with('success', 'Accompanying person removed successfully!');
    }
    public function checkAlumniMember(Request $request)
    {
        $user = Auth::guard('alumni')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first to check alumni details.'
            ], 401);
        }

        $membershipId = strtoupper(trim($request->input('membership_id')));

        if (empty($membershipId)) {
            return response()->json([
                'success' => false,
                'message' => 'Membership ID is required.'
            ], 400);
        }

        // Check if user is trying to add themselves
        if ($user->membership_id && $membershipId === strtoupper(trim($user->membership_id))) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot add yourself as an accompanying person.'
            ], 403);
        }

        // Search in database
        $alumni = AlumniRegistration::where('membership_id', $membershipId)->first();

        if ($alumni) {
            $fullName = trim("{$alumni->title} {$alumni->firstname} {$alumni->middlename} {$alumni->lastname}");

            return response()->json([
                'success' => true,
                'name' => $fullName,
                'message' => 'Alumni found!'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Alumni not found with this Membership ID.'
        ], 404);
    }
    public function paymentPage()
{
    $user = Auth::guard('alumni')->user();
    $user->load('accompanyingPersons');
    
    // Calculate totals
    $registrationCharge = $user->amount_paid ?? 0;
    $accompanyingCharge = $user->accompanyingPersons->sum('charge');
    $totalAmount = $registrationCharge + $accompanyingCharge;
    
    return view('frontend.pages.payment', compact('user', 'registrationCharge', 'accompanyingCharge', 'totalAmount'));
}

public function addAccompanyingFromPayment(Request $request)
{
    $user = Auth::guard('alumni')->user();
    
    $validated = $request->validate([
        'belongs_to_pgi' => 'required|boolean',
        'has_membership' => 'nullable|boolean',
        'requires_membership' => 'nullable|boolean',
        'member_id' => 'nullable|string|max:255',
        'title' => 'required|string|max:10',
        'full_name' => 'required|string|max:255',
        'age' => 'required|integer|min:1|max:150',
        'gender' => 'required|in:Male,Female,Other',
    ]);

    // Calculate charge
    $rateConfig = AccompanyingPersonRate::where('status', true)->first();
    $baseCharge = $rateConfig ? $rateConfig->base_rate : 5000;
    $finalCharge = $baseCharge;

    $isAlumni = $request->belongs_to_pgi == 1;
    $wantsMembership = $request->requires_membership == 1;

    // Apply discount logic
    if ($isAlumni) {
        if ($rateConfig && $rateConfig->is_discount_enabled) {
            $discountAmount = ($baseCharge * $rateConfig->discount_percentage) / 100;
            $finalCharge = $baseCharge - $discountAmount;
        }
    }

    $user->accompanyingPersons()->create([
        'name' => $request->full_name,
        'relation' => 'Accompanying Person',
        'is_alumni' => $isAlumni,
        'alumni_membership_id' => $request->member_id,
        'wants_membership' => $wantsMembership,
        'charge' => round($finalCharge, 2),
        'title' => $request->title,
    ]);

    return back()->with('success', 'Accompanying person added successfully!');
}

public function deleteAccompanyingFromPayment($id)
{
    $user = Auth::guard('alumni')->user();
    $person = $user->accompanyingPersons()->findOrFail($id);
    $person->delete();
    
    return back()->with('success', 'Accompanying person removed successfully!');
}
}

