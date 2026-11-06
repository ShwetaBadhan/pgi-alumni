<?php

namespace App\Http\Controllers;

use App\Models\{AlumniRegistration, AlumniProfile, AlumniDocument, RegistrationType, AccompanyingPersonRate, Payment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Http, Log, Storage};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumniRegistrationsExport;

class AlumniRegistrationController extends Controller
{
    // ==========================================
    // 1. ADMIN / BACKEND METHODS
    // ==========================================

        public function index(Request $request)
    {
       
        $query = AlumniRegistration::with(['registrationType', 'profile', 'payments']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($p) use ($search) {
                        $p->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('contact_number', 'like', "%{$search}%");
                    });
            });
        }

        return view('backend.pages.alumni-registrations.index', [
            'registrations' => $query->latest()->paginate(15),
            'filter' => $request->filter
        ]);
    }

        public function create()
    {
        return view('backend.pages.alumni-registrations.create', [
            'titles' => config('alumni_options.titles'),
            'degrees' => config('alumni_options.degrees'),
            'departments' => config('alumni_options.departments'),
            'allCountries' => config('alumni_options.all_countries'), 
            'saarcCountries' => config('alumni_options.saarc_countries'),
            'registrationTypes' => RegistrationType::where('status', 'active')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:alumni_registrations,email',
            'password' => 'required|min:8|confirmed',
            'registration_type_id' => 'required|exists:registration_types,id',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'contact_number' => 'required|string',
            'degree_completed' => 'required|string',
            'department' => 'required|string',
            'title' => 'required|string',
            'date_of_birth' => 'required|date',
            'residence_country' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Core
            $registration = AlumniRegistration::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'registration_type_id' => $validated['registration_type_id'],
                'status' => 'approved',
            ]);

            // 2. Profile
            $registration->profile()->create([
                'title' => $request->title,
                'firstname' => $validated['firstname'],
                'middlename' => $request->middlename,
                'lastname' => $validated['lastname'],
                'date_of_birth' => $validated['date_of_birth'],
                'contact_number' => $validated['contact_number'],
                'whatsapp_number' => $request->whatsapp_number,
                'degree_completed' => $validated['degree_completed'],
                'department' => $validated['department'],
                'year_of_passing' => $request->year_of_passing,
                'residence_country' => $validated['residence_country'],
            ]);

            // 3. Documents
            $photoPath = $request->hasFile('profile_photo_path') ? $request->file('profile_photo_path')->store('alumni-photos', 'public') : null;
            $registration->documents()->create([
                'profile_photo_path' => $photoPath,
                'agreed_to_rules' => true,
            ]);

            DB::commit();
            return redirect()->route('alumni-registrations.index')->with('success', 'Alumni added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add alumni: ' . $e->getMessage())->withInput();
        }
    }

    public function show(AlumniRegistration $alumniRegistration)
    {
        $alumniRegistration->load(['registrationType', 'profile', 'documents', 'payments', 'accompanyingPersons']);
        return view('backend.pages.alumni-registrations.show', compact('alumniRegistration'));
    }

    public function edit(AlumniRegistration $alumniRegistration)
    {
        $alumniRegistration->load('profile');
        return view('backend.pages.alumni-registrations.edit', [
            'alumniRegistration' => $alumniRegistration,
            'titles' => config('alumni_options.titles'),
            'degrees' => config('alumni_options.degrees'),
            'departments' => config('alumni_options.departments'),
            'allCountries' => config('alumni_options.all_countries'),
            'saarcCountries' => config('alumni_options.saarc_countries'),
            'registrationTypes' => RegistrationType::all()
        ]);
    }

    public function update(Request $request, AlumniRegistration $alumniRegistration)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:alumni_registrations,email,' . $alumniRegistration->id,
            'password' => 'nullable|min:8|confirmed',
            'registration_type_id' => 'required|exists:registration_types,id',
            'status' => 'required|in:pending,payment_pending,approved,rejected,payment_failed,refunded',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'contact_number' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'email' => $validated['email'],
                'registration_type_id' => $validated['registration_type_id'],
                'status' => $validated['status'],
            ];
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }
            $alumniRegistration->update($updateData);

            $alumniRegistration->profile()->update([
                'title' => $request->title,
                'firstname' => $validated['firstname'],
                'middlename' => $request->middlename,
                'lastname' => $validated['lastname'],
                'date_of_birth' => $request->date_of_birth,
                'contact_number' => $validated['contact_number'],
                'whatsapp_number' => $request->whatsapp_number,
                'degree_completed' => $request->degree_completed,
                'department' => $request->department,
                'year_of_passing' => $request->year_of_passing,
                'residence_country' => $request->residence_country,
            ]);

            if ($request->hasFile('profile_photo_path')) {
                if ($alumniRegistration->documents && $alumniRegistration->documents->profile_photo_path) {
                    Storage::disk('public')->delete($alumniRegistration->documents->profile_photo_path);
                }
                $alumniRegistration->documents()->updateOrCreate(
                    ['alumni_registration_id' => $alumniRegistration->id],
                    ['profile_photo_path' => $request->file('profile_photo_path')->store('alumni-photos', 'public')]
                );
            }

            DB::commit();
            return redirect()->route('alumni-registrations.index')->with('success', 'Alumni updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(AlumniRegistration $alumniRegistration)
    {
        $alumniRegistration->delete();
        return back()->with('success', 'Registration deleted successfully!');
    }

    public function approve(AlumniRegistration $alumniRegistration)
    {
        DB::beginTransaction();
        try {
            // 1. Approve Registration Status 
            $alumniRegistration->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);


            $alumniRegistration->payments()
                ->where('type', 'registration')
                ->where('status', 'pending')
                ->update(['status' => 'success']);

            DB::commit();
            return back()->with('success', 'Registration and Membership payment approved successfully! Other payments remain under verification.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve: ' . $e->getMessage());
        }
    }
    public function reject(Request $request, AlumniRegistration $alumniRegistration)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);
        $alumniRegistration->update([
            'status' => 'rejected',
            'comment' => ($alumniRegistration->comment ? $alumniRegistration->comment . "\n\n" : '') . 'Admin Rejection: ' . $request->rejection_reason
        ]);
        return back()->with('success', 'Registration rejected successfully.');
    }

    // ==========================================
    // 2. FRONTEND REGISTRATION METHODS
    // ==========================================

    public function showRegistrationForm()
    {
        return view('frontend.pages.registration-new', [
            'countries' => config('alumni_options.all_countries'),
            'saarcCountries' => config('alumni_options.saarc_countries'),
            'registrationTypes' => RegistrationType::where('status', 'active')->get()
        ]);
    }

           public function storeFrontendRegistration(Request $request)
    {
        // ✅ LOG 1: Check karein ki request controller tak aa rahi hai ya nahi
        Log::info('=== REGISTRATION STARTED ===', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required',
            'degree_completed' => 'required',
            'department' => 'required',
            'email' => 'required|email|unique:alumni_registrations,email',
            'password' => 'required|min:8|confirmed',
            'residence_country' => 'required',
            'registration_type_id' => 'required',
            'agreed_to_rules' => 'accepted',
            'cf-turnstile-response' => 'required',
        ]);

        if ($validator->fails()) {
            // ✅ LOG 2: Agar pehla validation fail hua
            Log::warning('REGISTRATION: Initial Validation Failed', $validator->errors()->toArray());
            return response()->json([
                'status' => 'error',
                'message' => 'Form validation failed. Check the errors below:',
                'errors' => $validator->errors()
            ]);
        }

        Log::info('REGISTRATION: Initial Validation Passed. Checking Captcha...');

        $captchaVerification = $this->verifyCloudflareCaptcha($request->input('cf-turnstile-response'));
        
        // ✅ LOG 3: Captcha ka exact response log karein
        Log::info('REGISTRATION: Captcha Response', $captchaVerification);

        if (!$captchaVerification['success']) {
            Log::warning('REGISTRATION: Captcha Failed', $captchaVerification);
            return back()->withErrors(['cf-turnstile-response' => 'CAPTCHA verification failed.'])->withInput();
        }

        Log::info('REGISTRATION: Captcha Passed. Running Main Validation...');

        $validated = $request->validate([
            'title' => 'required|in:Dr.,Prof.,Mr.,Mrs.,Ms.',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'contact_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'year_of_passing' => 'nullable|integer|min:1950|max:' . date('Y'),
            'year_of_joining_faculty' => 'nullable|integer|min:1950|max:' . date('Y'),
            'degree_completed' => 'required|string',
            'department' => 'required|string',
            'email' => 'required|email|unique:alumni_registrations,email',
            'password' => 'required|min:8|confirmed',
            'residence_country' => 'required|string',
            'registration_type_id' => 'required|exists:registration_types,id',
            'donation_amount' => 'nullable|numeric|min:0',
            'agreed_to_rules' => 'accepted',
            'cf-turnstile-response' => 'required',
        ]);

        Log::info('REGISTRATION: Main Validation Passed. Starting DB Transaction...');

        DB::beginTransaction();
        try {
            $regType = RegistrationType::findOrFail($validated['registration_type_id']);
            Log::info('REGISTRATION: Registration Type Found', ['type_id' => $regType->id, 'name' => $regType->name]);

            // 1. Core Record
            $registration = AlumniRegistration::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'registration_type_id' => $validated['registration_type_id'],
                'status' => 'payment_pending',
            ]);
            Log::info('REGISTRATION: Core Record Created', ['user_id' => $registration->id]);

            // 2. Profile Record
            $registration->profile()->create([
                'title' => $validated['title'],
                'firstname' => $validated['firstname'],
                'middlename' => $validated['middlename'],
                'lastname' => $validated['lastname'],
                'date_of_birth' => $validated['date_of_birth'],
                'contact_number' => $validated['contact_number'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'year_of_passing' => $validated['year_of_passing'] ?? null, 
                'year_of_joining_faculty' => $validated['year_of_joining_faculty'] ?? null,
                'degree_completed' => $validated['degree_completed'],
                'department' => $validated['department'],
                'residence_country' => $validated['residence_country'],
            ]);
            Log::info('REGISTRATION: Profile Record Created');

            // 3. Document Record
            $photoPath = null;
            if ($request->hasFile('profile_photo_path')) {
                $photoPath = $request->file('profile_photo_path')->store('alumni-photos', 'public');
                Log::info('REGISTRATION: Photo Uploaded', ['path' => $photoPath]);
            }

            $registration->documents()->create([
                'profile_photo_path' => $photoPath,
                'agreed_to_rules' => true,
            ]);
            Log::info('REGISTRATION: Document Record Created');

            DB::commit();
            Log::info('REGISTRATION: DB Committed Successfully!');

            Auth::guard('alumni')->login($registration);
            Log::info('REGISTRATION: User Logged In');

            if (isset($validated['donation_amount']) && $validated['donation_amount'] > 0) {
                session(['pending_donation' => $validated['donation_amount']]);
                Log::info('REGISTRATION: Donation added to session', ['amount' => $validated['donation_amount']]);
            }

            Log::info('=== REGISTRATION COMPLETED SUCCESSFULLY ===');
            return redirect()->route('alumni.payment')->with('success', 'Registration successful! Please complete your payment.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            // ✅ LOG 4: Exact error aur uski line number capture karein
            Log::error('=== REGISTRATION FAILED ===', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }

    // ==========================================
    // 3. PAYMENT & ACCOMPANYING PERSONS METHODS
    // ==========================================

              public function paymentPage()
    {
        $user = Auth::guard('alumni')->user();
        $user->load(['accompanyingPersons', 'payments', 'registrationType']);

        $regType = RegistrationType::find($user->registration_type_id);
        $registrationCharge = $regType ? $regType->amount : 0;
        
        // ✅ Actual accompanying persons ka charge calculate karein
        $actualAccompanyingCharge = $user->accompanyingPersons()->sum('charge');
        $actualAccompanyingCount = $user->accompanyingPersons()->count();
        
        // ✅ Session se pending amounts
        $pendingAccCharge = session('pending_accompanying_charge', 0);
        $pendingDonation = session('pending_donation', 0);
        
        // ✅ VALIDATION: Agar actual accompanying persons 0 hain, toh session ko bhi 0 kar dein
        if ($actualAccompanyingCount == 0 && $pendingAccCharge > 0) {
            session(['pending_accompanying_charge' => 0]);
            $pendingAccCharge = 0;
        }
        
        // ✅ VALIDATION: Agar actual charge aur session me alag hai, toh session ko update karein
        if ($actualAccompanyingCharge != $pendingAccCharge && $actualAccompanyingCount > 0) {
            session(['pending_accompanying_charge' => $actualAccompanyingCharge]);
            $pendingAccCharge = $actualAccompanyingCharge;
        }
        
        // ✅ Total Paid Amount
        $totalPaidEver = $user->payments()->sum('amount');
        
        // ✅ Total Required Amount (Registration + Accompanying + Donation)
        $totalAmount = $registrationCharge + $actualAccompanyingCharge + $pendingDonation;
        
        // ✅ Balance Due Calculation:
        if ($totalPaidEver == 0) {
            // First payment - Registration fee + pending amounts
            $balanceDue = $registrationCharge + $pendingAccCharge + $pendingDonation;
        } else {
            // Subsequent payments - Only pending amounts
            $balanceDue = $pendingAccCharge + $pendingDonation;
        }

        // ✅ Fix: Blade file ke liye variable ka naam same rakhein
        $accompanyingCharge = $actualAccompanyingCharge;

        return view('frontend.pages.payment', compact(
            'user',
            'registrationCharge',
            'accompanyingCharge', // ✅ Ab ye sahi string hai, => nahi
            'pendingAccCharge',
            'pendingDonation',
            'balanceDue',
            'totalAmount',
            'totalPaidEver'
        ));
    }

          public function submitUtr(Request $request)
    {
        $user = Auth::guard('alumni')->user();

      
        $pendingAccCharge = session('pending_accompanying_charge', 0);
        $pendingDonation = session('pending_donation', 0);

        
        $regType = RegistrationType::find($user->registration_type_id);
        $registrationCharge = $regType ? $regType->amount : 0;
        
       
        $totalPaidEver = $user->payments()->sum('amount');
        
       
        if ($totalPaidEver == 0) {
           
            $thisPaymentAmount = $registrationCharge + $pendingAccCharge + $pendingDonation;
        } else {
          
            $thisPaymentAmount = $pendingAccCharge + $pendingDonation;
        }
        
      
        if ($thisPaymentAmount <= 0) {
            return back()->with('error', 'Payment amount cannot be zero. Please contact support.');
        }

      
        Log::info('--- PAYMENT SUBMIT DEBUG ---', [
            'user_id' => $user->id,
            'registration_charge' => $registrationCharge,
            'pending_acc_charge' => $pendingAccCharge,
            'pending_donation' => $pendingDonation,
            'total_paid_ever' => $totalPaidEver,
            'final_payment_amount' => $thisPaymentAmount,
        ]);

        $validated = $request->validate([
            'confirm_payment' => 'required|accepted',
            'payment_transaction_id' => 'required|string|max:50',
            'payment_screenshot' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $screenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
        }

    
        $paymentType = 'registration'; // Default
        
        if ($pendingDonation > 0 && $pendingAccCharge == 0 && $totalPaidEver >= $registrationCharge) {
            $paymentType = 'donation';
        } elseif ($pendingAccCharge > 0) {
            $paymentType = 'accompanying';
        }

        Log::info('Payment Type Decided', ['final_type' => $paymentType]);

        
        $user->payments()->create([
            'registration_type_id' => $user->registration_type_id,
            'type' => $paymentType,
            'amount' => $thisPaymentAmount,
            'currency' => 'INR',
            'gateway' => 'manual_upi',
            'utr_number' => $validated['payment_transaction_id'],
            'screenshot_path' => $screenshotPath,
            'status' => 'pending',
        ]);

       
        session()->forget('pending_accompanying_charge');
        session()->forget('pending_donation');

        $user->update(['status' => 'payment_pending']);

        return redirect()->route('alumni.profile')->with('success', 'Payment of INR ' . number_format($thisPaymentAmount, 2) . ' submitted successfully!');
    }

    public function addAccompanyingFromPayment(Request $request)
    {
        $user = Auth::guard('alumni')->user();
        $validated = $request->validate([
            'belongs_to_pgi' => 'required|boolean',
            'title' => 'required|string|max:10',
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|in:Male,Female,Other',
            'requires_membership' => 'nullable|boolean',
            'member_id' => 'nullable|string|max:255',
        ]);

        $rateConfig = AccompanyingPersonRate::where('status', true)->first();
        $baseCharge = $rateConfig ? $rateConfig->base_rate : 5000;
        $finalCharge = $baseCharge;

        if ($request->belongs_to_pgi == 1 && $rateConfig && $rateConfig->is_discount_enabled) {
            $finalCharge = $baseCharge - (($baseCharge * $rateConfig->discount_percentage) / 100);
        }

        $user->accompanyingPersons()->create([
            'name' => $request->full_name,
            'relation' => 'Accompanying Person',
            'is_alumni' => $request->belongs_to_pgi == 1,
            'alumni_membership_id' => $request->member_id,
            'wants_membership' => $request->requires_membership == 1,
            'charge' => round($finalCharge, 2),
            'title' => $request->title,
            'age' => $request->age,
            'gender' => $request->gender,
        ]);

        // ✅ Is naye charge ko "Pending Payment" bucket (session) me add kar do
        $currentPending = session('pending_accompanying_charge', 0);
        session(['pending_accompanying_charge' => $currentPending + $finalCharge]);

        return redirect()->route('alumni.payment')->with('success', 'Accompanying person added! Please pay the new charge of INR ' . number_format($finalCharge, 2));
    }

    public function submitDonation(Request $request)
    {
        $validated = $request->validate([
            'donation_amount' => 'required|numeric|min:100'
        ]);

        
        session(['pending_donation' => $validated['donation_amount']]);

        return redirect()->route('alumni.payment')->with('success', 'Donation added! Please complete this new payment via UPI.');
    }
    // public function submitUtr(Request $request)
    // {
    //     $user = Auth::guard('alumni')->user();

    //     $regType = RegistrationType::find($user->registration_type_id);
    //     $registrationCharge = $regType ? $regType->amount : 0;
    //     $accompanyingCharge = $user->accompanyingPersons()->sum('charge');
    //     $donationCharge = session('pending_donation', 0);

    //     // ✅ Same Foolproof Logic
    //     $coreTotal = $registrationCharge + $accompanyingCharge;
    //     $corePaid = $user->payments()->where('type', '!=', 'donation')->sum('amount');
    //     $coreBalance = max(0, $coreTotal - $corePaid);

    //     // User abhi exactly yeh amount pay kar raha hai
    //     $thisPaymentAmount = $coreBalance + $donationCharge;

    //     $validated = $request->validate([
    //         'confirm_payment' => 'required|accepted',
    //         'payment_transaction_id' => 'required|string|max:50',
    //         'payment_screenshot' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);

    //     $screenshotPath = null;
    //     if ($request->hasFile('payment_screenshot')) {
    //         $screenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
    //     }

    //     // ✅ Payment Type Decide Karein
    //     $paymentType = 'registration'; // Default

    //     // Agar Core bill pura pay ho chuka hai, aur ab sirf Donation bacha hai
    //     if ($donationCharge > 0 && $coreBalance == 0) {
    //         $paymentType = 'donation';
    //     }

    //     // Session clear karein
    //     if ($donationCharge > 0) {
    //         session()->forget('pending_donation');
    //     }

    //     $user->payments()->create([
    //         'registration_type_id' => $user->registration_type_id,
    //         'type' => $paymentType,
    //         'amount' => $thisPaymentAmount,
    //         'currency' => 'INR',
    //         'gateway' => 'manual_upi',
    //         'utr_number' => $validated['payment_transaction_id'],
    //         'screenshot_path' => $screenshotPath,
    //         'status' => 'pending',
    //     ]);

    //     $user->update(['status' => 'payment_pending']);

    //     return redirect()->route('alumni.profile')->with('success', 'Payment details submitted! Admin will verify shortly.');
    // }
    // public function addAccompanyingFromPayment(Request $request)
    // {
    //     $user = Auth::guard('alumni')->user();
    //     $validated = $request->validate([
    //         'belongs_to_pgi' => 'required|boolean',
    //         'title' => 'required|string|max:10',
    //         'full_name' => 'required|string|max:255',
    //         'age' => 'required|integer|min:1|max:150',
    //         'gender' => 'required|in:Male,Female,Other',
    //         'requires_membership' => 'nullable|boolean',
    //         'member_id' => 'nullable|string|max:255',
    //     ]);

    //     $rateConfig = AccompanyingPersonRate::where('status', true)->first();
    //     $baseCharge = $rateConfig ? $rateConfig->base_rate : 5000;
    //     $finalCharge = $baseCharge;

    //     if ($request->belongs_to_pgi == 1 && $rateConfig && $rateConfig->is_discount_enabled) {
    //         $finalCharge = $baseCharge - (($baseCharge * $rateConfig->discount_percentage) / 100);
    //     }

    //     // ✅ Accompanying person create karein
    //     $person = $user->accompanyingPersons()->create([
    //         'name' => $request->full_name,
    //         'relation' => 'Accompanying Person',
    //         'is_alumni' => $request->belongs_to_pgi == 1,
    //         'alumni_membership_id' => $request->member_id,
    //         'wants_membership' => $request->requires_membership == 1,
    //         'charge' => round($finalCharge, 2),
    //         'title' => $request->title,
    //         'age' => $request->age,
    //         'gender' => $request->gender,
    //     ]);

    //     // ✅ Debug: Log me likhein ki person save hua ya nahi
    //     Log::info('Accompanying person created: ', [
    //         'id' => $person->id,
    //         'name' => $person->name,
    //         'charge' => $person->charge,
    //         'user_id' => $user->id
    //     ]);

    //     return redirect()->route('alumni.payment')->with('success', 'Accompanying person added! Charge: INR ' . number_format($finalCharge, 2));
    // }

    // public function submitDonation(Request $request)
    // {
    //     $validated = $request->validate([
    //         'donation_amount' => 'required|numeric|min:100'
    //     ]);

    //     // ✅ Save only in the session; do NOT create a payment record in the DB
    //     session(['pending_donation' => $validated['donation_amount']]);

    //     return redirect()->route('alumni.payment')->with('success', 'Donation amount added to your payment queue! Please complete payment via UPI.');
    // }
       public function deleteAccompanyingFromPayment($id)
    {
        $user = Auth::guard('alumni')->user();
        $person = $user->accompanyingPersons()->findOrFail($id);
        
        // ✅ Person ka charge session se minus karein
        $personCharge = $person->charge;
        $currentPending = session('pending_accompanying_charge', 0);
        $newPending = max(0, $currentPending - $personCharge); 
        
        session(['pending_accompanying_charge' => $newPending]);
        
        // ✅ Ab person ko delete karein
        $person->delete();

        return back()->with('success', 'Accompanying person removed! Charge of INR ' . number_format($personCharge, 2) . ' deducted from payment.');
    }

    public function updatePreference(Request $request)
    {
        $user = Auth::guard('alumni')->user();
        $validated = $request->validate(['registration_type_id' => 'required|exists:registration_types,id']);

        $newRegType = RegistrationType::findOrFail($validated['registration_type_id']);
        $user->update([
            'registration_type_id' => $validated['registration_type_id'],
        ]);

        return back()->with('success', 'Registration type updated successfully!');
    }

    // ==========================================
    // 4. HELPER METHODS
    // ==========================================

    private function verifyCloudflareCaptcha($token)
    {
        if (empty($token)) return ['success' => false, 'error' => 'CAPTCHA token is missing.'];

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('CLOUDFLARE_TURNSTILE_SECRET_KEY'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $result = $response->json();
        if (empty($result['success'])) {
            Log::error('Cloudflare Turnstile Verification Failed: ', $result);
        }
        return $result;
    }

    public function export(Request $request)
    {
        $filename = 'alumni_registrations_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new AlumniRegistrationsExport($request), $filename);
    }
        public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);
        
        
        $payment->update(['status' => 'success']);
        
      
        $user = $payment->alumniRegistration;
        
        // 3. ✅ AUTO-APPROVE LOGIC
        if ($user && $user->status !== 'approved') {
           
            $regType = RegistrationType::find($user->registration_type_id);
            $requiredAmount = $regType ? $regType->amount : 0;
           
            $totalPaid = $user->payments()->where('status', 'success')->sum('amount');
            
           if ($totalPaid >= $requiredAmount) {
                $user->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id()
                ]);
            }
        }

        return back()->with('success', 'Payment approved successfully!');
    }
}
