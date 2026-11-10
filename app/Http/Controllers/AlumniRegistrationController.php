<?php

namespace App\Http\Controllers;

use App\Models\{AlumniRegistration, AlumniProfile, AlumniDocument, RegistrationType, AccompanyingPersonRate, Payment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Http, Log, Storage};
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
            // 1. Core Record
            $registration = AlumniRegistration::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'registration_type_id' => $validated['registration_type_id'],
                'status' => 'approved',
            ]);

            // 2. Profile Record
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

            // 3. Document Record
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
        // ✅ Load 'profile', 'documents', and 'payments' relationships
        $alumniRegistration->load(['profile', 'documents', 'payments']);

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
        // ✅ Strict validation for ALL required form fields to ensure errors are caught and displayed
        $validated = $request->validate([
            'email' => 'required|email|unique:alumni_registrations,email,' . $alumniRegistration->id,
            'password' => 'nullable|min:8|confirmed',
            'registration_type_id' => 'required|exists:registration_types,id',
            'status' => 'required|in:pending,payment_pending,approved,rejected,payment_failed,refunded',
            'title' => 'required|string',
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'lastname' => 'required|string',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string',
            'whatsapp_number' => 'nullable|string',
            'degree_completed' => 'required|string',
            'department' => 'required|string',
            'year_of_passing' => 'nullable|integer',
            'residence_country' => 'required|string',
            'payment_transaction_date' => 'required|date',
            'payment_transaction_id' => 'required|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'email' => $validated['email'],
                'registration_type_id' => $validated['registration_type_id'],
                'status' => $validated['status'],
                'payment_transaction_date' => $validated['payment_transaction_date'],
                'payment_transaction_id' => $validated['payment_transaction_id'],
            ];

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $alumniRegistration->update($updateData);

            $alumniRegistration->profile()->update([
                'title' => $validated['title'],
                'firstname' => $validated['firstname'],
                'middlename' => $validated['middlename'],
                'lastname' => $validated['lastname'],
                'date_of_birth' => $validated['date_of_birth'],
                'contact_number' => $validated['contact_number'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'degree_completed' => $validated['degree_completed'],
                'department' => $validated['department'],
                'year_of_passing' => $validated['year_of_passing'],
                'residence_country' => $validated['residence_country'],
            ]);

            // Handle Profile Photo Update
            if ($request->hasFile('profile_photo_path')) {
                if ($alumniRegistration->documents && $alumniRegistration->documents->profile_photo_path) {
                    Storage::disk('public')->delete($alumniRegistration->documents->profile_photo_path);
                }
                $alumniRegistration->documents()->updateOrCreate(
                    ['alumni_registration_id' => $alumniRegistration->id],
                    ['profile_photo_path' => $request->file('profile_photo_path')->store('alumni-photos', 'public')]
                );
            }

            // ✅ Handle Documentary Proof Update (Added this as it was missing)
            if ($request->hasFile('documentary_proof')) {
                if ($alumniRegistration->documents && $alumniRegistration->documents->documentary_proof) {
                    Storage::disk('public')->delete($alumniRegistration->documents->documentary_proof);
                }
                $alumniRegistration->documents()->updateOrCreate(
                    ['alumni_registration_id' => $alumniRegistration->id],
                    ['documentary_proof' => $request->file('documentary_proof')->store('alumni-documents', 'public')]
                );
            }

            DB::commit();
            return redirect()->route('alumni-registrations.index')->with('success', 'Alumni updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Alumni Update Failed: ' . $e->getMessage());
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
        $captchaVerification = $this->verifyCloudflareCaptcha($request->input('cf-turnstile-response'));

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

        // Calculate actual accompanying persons total charge from database
        $actualAccompanyingCharge = $user->accompanyingPersons()->sum('charge');

        // Total amount user has paid so far
        $totalPaidEver = $user->payments()->sum('amount');

        $pendingDonation = session('pending_donation', 0);
        $pendingAccCharge = session('pending_accompanying_charge', 0);

        // ✅ SMART FIX: If user has already paid for Registration + Accompanying, 
        // any old accompanying charge in the session is stale and should be reset to 0.
        if ($totalPaidEver >= ($registrationCharge + $actualAccompanyingCharge)) {
            $pendingAccCharge = 0;
            session()->forget('pending_accompanying_charge');
        }

        // Total Required Amount
        $totalAmount = $registrationCharge + $actualAccompanyingCharge + $pendingDonation;

        // Balance Due Calculation
        if ($totalPaidEver == 0) {
            // First payment - Registration fee + pending amounts
            $balanceDue = $registrationCharge + $pendingAccCharge + $pendingDonation;
        } else {
            // Subsequent payments - Only pending amounts
            $balanceDue = $pendingAccCharge + $pendingDonation;
        }

        // Fix: Keep variable name consistent for Blade file
        $accompanyingCharge = $actualAccompanyingCharge;

        return view('frontend.pages.payment', compact(
            'user',
            'registrationCharge',
            'accompanyingCharge',
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

        $validated = $request->validate([
            'confirm_payment' => 'required|accepted',
            'payment_transaction_id' => 'required|string|max:50',
            'payment_screenshot' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $screenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
        }

        DB::beginTransaction();
        try {
            // ✅ FIX: If it's the first payment and includes a donation, create separate records for proper accounting
            if ($totalPaidEver == 0 && $pendingDonation > 0) {

                // 1. Payment record for Registration (and Accompanying if applicable)
                $user->payments()->create([
                    'registration_type_id' => $user->registration_type_id,
                    'type' => 'registration',
                    'amount' => $registrationCharge + $pendingAccCharge,
                    'currency' => 'INR',
                    'gateway' => 'manual_upi',
                    'utr_number' => $validated['payment_transaction_id'],
                    'screenshot_path' => $screenshotPath,
                    'status' => 'pending',
                ]);

                // 2. Separate payment record for Donation (with the same UTR)
                $user->payments()->create([
                    'registration_type_id' => $user->registration_type_id,
                    'type' => 'donation',
                    'amount' => $pendingDonation,
                    'currency' => 'INR',
                    'gateway' => 'manual_upi',
                    'utr_number' => $validated['payment_transaction_id'],
                    'screenshot_path' => $screenshotPath,
                    'status' => 'pending',
                ]);
            } else {
                // Normal single payment record (when only one item is being paid)
                $paymentType = 'registration'; // Default

                if ($pendingDonation > 0 && $pendingAccCharge == 0 && $totalPaidEver >= $registrationCharge) {
                    $paymentType = 'donation';
                } elseif ($pendingAccCharge > 0) {
                    $paymentType = 'accompanying';
                }

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
            }

            // ✅ Clear session since payment was successfully submitted
            session()->forget('pending_accompanying_charge');
            session()->forget('pending_donation');

            $user->update(['status' => 'payment_pending']);

            DB::commit();
            return redirect()->route('alumni.profile')->with('success', 'Payment of INR ' . number_format($thisPaymentAmount, 2) . ' submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Submission Failed: ' . $e->getMessage());
            return back()->with('error', 'Payment submission failed. Please try again.');
        }
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

        // ✅ Add this new charge to the "Pending Payment" session bucket
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

    public function deleteAccompanyingFromPayment($id)
    {
        $user = Auth::guard('alumni')->user();
        $person = $user->accompanyingPersons()->findOrFail($id);

        // ✅ Deduct the person's charge from the session
        $personCharge = $person->charge;
        $currentPending = session('pending_accompanying_charge', 0);
        $newPending = max(0, $currentPending - $personCharge);

        session(['pending_accompanying_charge' => $newPending]);

        // ✅ Now delete the person
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

    // Preview dikhane ke liye
    public function showReceipt(Payment $payment)
    {
        $payment->load(['alumniRegistration.profile', 'alumniRegistration.registrationType']);

        $alumni = $payment->alumniRegistration;
        $membershipId = $alumni->membership_id ?? 'N/A';

        // Amount in words (Safe for Shared Hosting)
        $amountWords = null;

        // Check if intl extension is enabled
        if (class_exists('NumberFormatter')) {
            try {
                $fmt = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
                $rupees = (int) floor($payment->amount);
                $paise = (int) round(($payment->amount - $rupees) * 100);
                $amountWords = ucfirst($fmt->format($rupees)) . ' rupees' . ($paise ? ' and ' . $fmt->format($paise) . ' paise' : '');
            } catch (\Exception $e) {
                $amountWords = null; // Fallback if it fails
            }
        }


        if (!$amountWords) {
            $amountWords = number_format($payment->amount, 2) . ' INR';
        }

        $data = compact('payment', 'alumni', 'membershipId', 'amountWords');

        // Preview view return karein
        return view('backend.pages.alumni-registrations.receipt-preview', $data);
    }


    public function downloadReceipt(Payment $payment)
    {
        $payment->load(['alumniRegistration.profile', 'alumniRegistration.registrationType']);

        $alumni = $payment->alumniRegistration;
        $membershipId = $alumni->membership_id ?? 'N/A';

        // Amount in words
        // Amount in words (Safe for Shared Hosting)
        $amountWords = null;

        // Check if intl extension is enabled
        if (class_exists('NumberFormatter')) {
            try {
                $fmt = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
                $rupees = (int) floor($payment->amount);
                $paise = (int) round(($payment->amount - $rupees) * 100);
                $amountWords = ucfirst($fmt->format($rupees)) . ' rupees' . ($paise ? ' and ' . $fmt->format($paise) . ' paise' : '');
            } catch (\Exception $e) {
                $amountWords = null; // Fallback if it fails
            }
        }


        if (!$amountWords) {
            $amountWords = number_format($payment->amount, 2) . ' INR';
        }

        $data = compact('payment', 'alumni', 'membershipId', 'amountWords');

        // PDF generate 
        $pdf = Pdf::loadView('backend.pages.alumni-registrations.receipt-pdf', $data);

        // PDF  download 
        $filename = 'Receipt_PGAAS' . $payment->id . '_' . date('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
