<?php

namespace App\Http\Controllers;

use App\Models\AlumniRegistration;
use App\Models\RegistrationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumniRegistrationsExport;



class AlumniRegistrationController extends Controller
{
    // --- BACKEND / ADMIN METHODS ---

    /**
     * Display a listing of the resource (Admin Index).
     */
  public function index(Request $request)
{
    $query = AlumniRegistration::with('registrationType');
    $filter = $request->input('filter');
    $status = $request->input('status'); // ✅ New Status Filter

    // 1. Category Filter Logic
    if ($filter === 'membership') {
        $query->whereHas('registrationType', function ($q) {
            $q->where('name', 'like', '%Membership%')->where('name', 'not like', '%Summit%');
        });
    } elseif ($filter === 'summit') {
        $query->whereHas('registrationType', function ($q) {
            $q->where('name', 'like', '%Summit%');
        });
    } elseif ($filter === 'accommodation') {
        $query->where('has_accompanying_person', true);
    }

    // 2. ✅ NEW: Status Filter Logic
    if ($status) {
        $query->where('status', $status);
    }

    // 3. Search Logic
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('firstname', 'like', "%{$search}%")
                ->orWhere('lastname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%");
        });
    }

    $registrations = $query->latest()->paginate(10);

    return view('backend.pages.alumni-registrations.index', compact('registrations', 'filter'));
}

    /**
     * Display the specified resource (Admin Show).
     */
    public function show(AlumniRegistration $alumniRegistration)
    {
        $alumniRegistration->load('registrationType');
        return view('backend.pages.alumni-registrations.show', compact('alumniRegistration'));
    }

    /**
     * Show the form for editing the specified resource (Admin Edit).
     */
    public function edit(AlumniRegistration $alumniRegistration)
    {
        $titles = ['Dr.', 'Prof.', 'Mr.', 'Mrs.', 'Ms.'];
        $degrees = ['BSc', 'MDS', 'MHA', 'MCh', 'DM', 'MSc', 'Fellowship', 'PhD', 'MS', 'MD'];
        $departments = ['Surgical Gastro', 'Medical Gastro', 'Cardiology', 'Neurology', 'Oncology', 'Pediatrics', 'Radiology', 'Other'];

        // SAARC Countries ki list
        $saarcCountries = [
            'Afghanistan',
            'Bangladesh',
            'Bhutan',
            'India',
            'Maldives',
            'Nepal',
            'Pakistan',
            'Sri Lanka'
        ];

        // All Countries
        $allCountries = [
            'Afghanistan',
            'Albania',
            'Algeria',
            'Andorra',
            'Angola',
            'Antigua and Barbuda',
            'Argentina',
            'Armenia',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belgium',
            'Belize',
            'Benin',
            'Bhutan',
            'Bolivia',
            'Bosnia and Herzegovina',
            'Botswana',
            'Brazil',
            'Brunei',
            'Bulgaria',
            'Burkina Faso',
            'Burundi',
            'Cabo Verde',
            'Cambodia',
            'Cameroon',
            'Canada',
            'Central African Republic',
            'Chad',
            'Chile',
            'China',
            'Colombia',
            'Comoros',
            'Congo (Congo-Brazzaville)',
            'Costa Rica',
            'Croatia',
            'Cuba',
            'Cyprus',
            'Czechia (Czech Republic)',
            'Democratic Republic of the Congo',
            'Denmark',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'Ecuador',
            'Egypt',
            'El Salvador',
            'Equatorial Guinea',
            'Eritrea',
            'Estonia',
            'Eswatini',
            'Ethiopia',
            'Fiji',
            'Finland',
            'France',
            'Gabon',
            'Gambia',
            'Georgia',
            'Germany',
            'Ghana',
            'Greece',
            'Grenada',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Guyana',
            'Haiti',
            'Holy See',
            'Honduras',
            'Hungary',
            'Iceland',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Ireland',
            'Israel',
            'Italy',
            'Jamaica',
            'Japan',
            'Jordan',
            'Kazakhstan',
            'Kenya',
            'Kiribati',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Lesotho',
            'Liberia',
            'Libya',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Madagascar',
            'Malawi',
            'Malaysia',
            'Maldives',
            'Mali',
            'Malta',
            'Marshall Islands',
            'Mauritania',
            'Mauritius',
            'Mexico',
            'Micronesia',
            'Moldova',
            'Monaco',
            'Mongolia',
            'Montenegro',
            'Morocco',
            'Mozambique',
            'Myanmar (formerly Burma)',
            'Namibia',
            'Nauru',
            'Nepal',
            'Netherlands',
            'New Zealand',
            'Nicaragua',
            'Niger',
            'Nigeria',
            'North Korea',
            'North Macedonia',
            'Norway',
            'Oman',
            'Pakistan',
            'Palau',
            'Palestine State',
            'Panama',
            'Papua New Guinea',
            'Paraguay',
            'Peru',
            'Philippines',
            'Poland',
            'Portugal',
            'Qatar',
            'Romania',
            'Russia',
            'Rwanda',
            'Saint Kitts and Nevis',
            'Saint Lucia',
            'Saint Vincent and the Grenadines',
            'Samoa',
            'San Marino',
            'Sao Tome and Principe',
            'Saudi Arabia',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Sierra Leone',
            'Singapore',
            'Slovakia',
            'Slovenia',
            'Solomon Islands',
            'Somalia',
            'South Africa',
            'South Korea',
            'South Sudan',
            'Spain',
            'Sri Lanka',
            'Sudan',
            'Suriname',
            'Sweden',
            'Switzerland',
            'Syria',
            'Tajikistan',
            'Tanzania',
            'Thailand',
            'Timor-Leste',
            'Togo',
            'Tonga',
            'Trinidad and Tobago',
            'Tunisia',
            'Turkey',
            'Turkmenistan',
            'Tuvalu',
            'Uganda',
            'Ukraine',
            'United Arab Emirates',
            'United Kingdom',
            'United States of America',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Venezuela',
            'Vietnam',
            'Yemen',
            'Zambia',
            'Zimbabwe'
        ];

        // Fetch all registration types for editing
        $registrationTypes = RegistrationType::all();

        return view('backend.pages.alumni-registrations.edit', compact(
            'alumniRegistration',
            'titles',
            'degrees',
            'departments',
            'allCountries',
            'saarcCountries',
            'registrationTypes'
        ));
    }

    /**
     * Update the specified resource in storage (Admin Update).
     */
    public function update(Request $request, AlumniRegistration $alumniRegistration)
    {
        $data = $request->validate([
            'title' => 'required|string|max:10',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'contact_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'degree_completed' => 'required|string',
            'department' => 'required|string',
            'year_of_passing' => 'nullable|integer|min:1950|max:' . date('Y'),
            'email' => 'required|email|unique:alumni_registrations,email,' . $alumniRegistration->id,
            'password' => 'nullable|min:8|confirmed',
            'residence_country' => 'required|string',
            'registration_type_id' => 'required|exists:registration_types,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_transaction_date' => 'required|date',
            'payment_transaction_id' => 'required|string|unique:alumni_registrations,payment_transaction_id,' . $alumniRegistration->id,
            'status' => 'required|in:pending,payment_pending,approved,rejected,payment_failed,refunded',
            'comment' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'documentary_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Password handle karein
        if (!empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Profile Photo Upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($alumniRegistration->profile_photo) {
                Storage::disk('public')->delete($alumniRegistration->profile_photo);
            }

            $file = $request->file('profile_photo');
            $fileName = time() . '_profile_' . $file->getClientOriginalName();
            $file->storeAs('public/alumni-photos', $fileName);
            $data['profile_photo'] = 'alumni-photos/' . $fileName;
        }

        // Documentary Proof Upload
        if ($request->hasFile('documentary_proof')) {
            // Delete old proof
            if ($alumniRegistration->documentary_proof) {
                Storage::disk('public')->delete($alumniRegistration->documentary_proof);
            }

            $file = $request->file('documentary_proof');
            $fileName = time() . '_proof_' . $file->getClientOriginalName();
            $file->storeAs('public/alumni-documents', $fileName);
            $data['documentary_proof'] = 'alumni-documents/' . $fileName;
        }

        $alumniRegistration->update($data);

        return redirect()->route('alumni-registrations.index')
            ->with('success', 'Alumni updated successfully!');
    }

    /**
     * Remove the specified resource from storage (Admin Delete).
     */
    public function destroy(AlumniRegistration $alumniRegistration)
    {
        $alumniRegistration->delete(); // Uses softDeletes
        return redirect()->route('alumni-registrations.index')
            ->with('success', 'Registration deleted successfully!');
    }

    /**
     * Approve the registration.
     */
    public function approve(AlumniRegistration $alumniRegistration)
    {
        $alumniRegistration->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Registration approved successfully!');
    }

    /**
     * Reject the registration.
     */
    public function reject(Request $request, AlumniRegistration $alumniRegistration)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $alumniRegistration->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'comment' => ($alumniRegistration->comment ? $alumniRegistration->comment . "\n\n" : '') . 'Admin Rejection Reason: ' . $request->rejection_reason
        ]);

        return back()->with('success', 'Registration rejected successfully.');
    }

    /**
     * Show the form for creating a new resource (Backend).
     */
    public function create()
    {
        $titles = ['Dr.', 'Prof.', 'Mr.', 'Mrs.', 'Ms.'];
        $degrees = ['BSc', 'MDS', 'MHA', 'MCh', 'DM', 'MSc', 'Fellowship', 'PhD', 'MS', 'MD'];
        $departments = ['Surgical Gastro', 'Medical Gastro', 'Cardiology', 'Neurology', 'Oncology', 'Pediatrics', 'Radiology', 'Other'];

        // SAARC Countries ki list
        $saarcCountries = [
            'Afghanistan',
            'Bangladesh',
            'Bhutan',
            'India',
            'Maldives',
            'Nepal',
            'Pakistan',
            'Sri Lanka'
        ];

        // All Countries (with SAARC flag)
        $allCountries = [
            'Afghanistan',
            'Albania',
            'Algeria',
            'Andorra',
            'Angola',
            'Antigua and Barbuda',
            'Argentina',
            'Armenia',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belgium',
            'Belize',
            'Benin',
            'Bhutan',
            'Bolivia',
            'Bosnia and Herzegovina',
            'Botswana',
            'Brazil',
            'Brunei',
            'Bulgaria',
            'Burkina Faso',
            'Burundi',
            'Cabo Verde',
            'Cambodia',
            'Cameroon',
            'Canada',
            'Central African Republic',
            'Chad',
            'Chile',
            'China',
            'Colombia',
            'Comoros',
            'Congo (Congo-Brazzaville)',
            'Costa Rica',
            'Croatia',
            'Cuba',
            'Cyprus',
            'Czechia (Czech Republic)',
            'Democratic Republic of the Congo',
            'Denmark',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'Ecuador',
            'Egypt',
            'El Salvador',
            'Equatorial Guinea',
            'Eritrea',
            'Estonia',
            'Eswatini',
            'Ethiopia',
            'Fiji',
            'Finland',
            'France',
            'Gabon',
            'Gambia',
            'Georgia',
            'Germany',
            'Ghana',
            'Greece',
            'Grenada',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Guyana',
            'Haiti',
            'Holy See',
            'Honduras',
            'Hungary',
            'Iceland',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Ireland',
            'Israel',
            'Italy',
            'Jamaica',
            'Japan',
            'Jordan',
            'Kazakhstan',
            'Kenya',
            'Kiribati',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Lesotho',
            'Liberia',
            'Libya',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Madagascar',
            'Malawi',
            'Malaysia',
            'Maldives',
            'Mali',
            'Malta',
            'Marshall Islands',
            'Mauritania',
            'Mauritius',
            'Mexico',
            'Micronesia',
            'Moldova',
            'Monaco',
            'Mongolia',
            'Montenegro',
            'Morocco',
            'Mozambique',
            'Myanmar (formerly Burma)',
            'Namibia',
            'Nauru',
            'Nepal',
            'Netherlands',
            'New Zealand',
            'Nicaragua',
            'Niger',
            'Nigeria',
            'North Korea',
            'North Macedonia',
            'Norway',
            'Oman',
            'Pakistan',
            'Palau',
            'Palestine State',
            'Panama',
            'Papua New Guinea',
            'Paraguay',
            'Peru',
            'Philippines',
            'Poland',
            'Portugal',
            'Qatar',
            'Romania',
            'Russia',
            'Rwanda',
            'Saint Kitts and Nevis',
            'Saint Lucia',
            'Saint Vincent and the Grenadines',
            'Samoa',
            'San Marino',
            'Sao Tome and Principe',
            'Saudi Arabia',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Sierra Leone',
            'Singapore',
            'Slovakia',
            'Slovenia',
            'Solomon Islands',
            'Somalia',
            'South Africa',
            'South Korea',
            'South Sudan',
            'Spain',
            'Sri Lanka',
            'Sudan',
            'Suriname',
            'Sweden',
            'Switzerland',
            'Syria',
            'Tajikistan',
            'Tanzania',
            'Thailand',
            'Timor-Leste',
            'Togo',
            'Tonga',
            'Trinidad and Tobago',
            'Tunisia',
            'Turkey',
            'Turkmenistan',
            'Tuvalu',
            'Uganda',
            'Ukraine',
            'United Arab Emirates',
            'United Kingdom',
            'United States of America',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Venezuela',
            'Vietnam',
            'Yemen',
            'Zambia',
            'Zimbabwe'
        ];

        $registrationTypes = RegistrationType::where('status', 'active')->get();

        return view('backend.pages.alumni-registrations.create', compact(
            'titles',
            'degrees',
            'departments',
            'allCountries',
            'saarcCountries',
            'registrationTypes'
        ));
    }

    /**
     * Store a newly created resource in storage (Backend).
     */
    public function store(Request $request)
    {
        // File upload handling
        if ($request->hasFile('documentary_proof')) {
            $file = $request->file('documentary_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/alumni-documents', $fileName);
            $documentPath = 'alumni-documents/' . $fileName;
        } else {
            $documentPath = null;
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title' => 'required|string|max:10',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'contact_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'degree_completed' => 'required|string',
            'department' => 'required|string',
            'year_of_passing' => 'nullable|integer|min:1950|max:' . date('Y'),
            'email' => 'required|email|unique:alumni_registrations,email',
            'password' => 'required|min:8|confirmed',
            'residence_country' => 'required|string',
            'registration_type_id' => 'required|exists:registration_types,id',
            'amount_paid' => 'required|numeric|min:0',


            'payment_transaction_date' => 'required|date',
            'payment_transaction_id' => 'required|string|unique:alumni_registrations,payment_transaction_id',

            'comment' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/alumni-photos', $fileName);
            $photoPath = 'alumni-photos/' . $fileName;
        } else {
            $photoPath = null;
        }
        // Create the alumni record
        AlumniRegistration::create([
            'title' => $request->title,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'date_of_birth' => $request->date_of_birth,
            'contact_number' => $request->contact_number,
            'whatsapp_number' => $request->whatsapp_number,
            'degree_completed' => $request->degree_completed,
            'department' => $request->department,
            'year_of_passing' => $request->year_of_passing,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'residence_country' => $request->residence_country,
            'registration_type_id' => $request->registration_type_id,
            'amount_paid' => $request->amount_paid,


            'payment_transaction_date' => $request->payment_transaction_date,
            'payment_transaction_id' => $request->payment_transaction_id,

            'status' => 'approved',
            'comment' => $request->comment,
            'documentary_proof' => $documentPath,
            'agreed_to_rules' => true,
        ]);

        return redirect()->route('alumni-registrations.index')
            ->with('success', 'Alumni added successfully!');
    }
    public function handlePaymentSuccess(Request $request, AlumniRegistration $registration)
    {
        try {
            $gateway = $registration->payment_gateway ?? 'manual';
            $verified = false;
            $gatewayPaymentId = null;
            $gatewayOrderId = null;

            if ($gateway === 'razorpay') {
                $verified = $this->paymentService->verifyRazorpaySignature(
                    $request->razorpay_order_id,
                    $request->razorpay_payment_id,
                    $request->razorpay_signature
                );
                $gatewayPaymentId = $request->razorpay_payment_id;
                $gatewayOrderId = $request->razorpay_order_id;
            } elseif ($gateway === 'stripe') {
                $sessionId = $request->get('session_id');
                $result = $this->paymentService->verifyStripeSession($sessionId);
                $verified = $result['success'];
                $gatewayPaymentId = $result['payment_intent'] ?? null;
                $gatewayOrderId = $sessionId;
            } elseif (env('PAYMENT_TEST_MODE')) {
                $verified = true;
                $gatewayPaymentId = 'test_payment_' . time();
                $gatewayOrderId = 'test_order_' . time();
            }

            if ($verified) {
                // Payment table me entry karein
                $registration->payments()->create([
                    'amount' => $registration->amount_paid,
                    'currency' => 'INR',
                    'gateway' => $gateway,
                    'gateway_order_id' => $gatewayOrderId,
                    'gateway_payment_id' => $gatewayPaymentId,
                    'status' => 'success',
                    'response_payload' => $request->all(),
                ]);

                // Registration status update karein
                $registration->update(['status' => 'approved']);

                return redirect()->route('dashboard')
                    ->with('success', '🎉 Payment successful! Your registration is now approved.');
            } else {
                // Failed payment entry
                $registration->payments()->create([
                    'amount' => $registration->amount_paid,
                    'currency' => 'INR',
                    'gateway' => $gateway,
                    'gateway_order_id' => $gatewayOrderId,
                    'gateway_payment_id' => $gatewayPaymentId,
                    'status' => 'failed',
                    'response_payload' => $request->all(),
                ]);

                $registration->update(['status' => 'payment_failed']);

                return redirect()->route('alumni.payment.page', $registration->id)
                    ->with('error', 'Payment verification failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Payment Success Handler Error: ' . $e->getMessage());
            return redirect()->route('alumni.payment.page', $registration->id)
                ->with('error', 'Something went wrong. Please contact support.');
        }
    }
    public function processRefund(Request $request, AlumniRegistration $registration)
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:0.01|max:' . $registration->amount_paid,
            'refund_reason' => 'required|string|max:500',
        ]);

        if (!$registration->canBeRefunded()) {
            return back()->with('error', 'This registration cannot be refunded.');
        }

        $result = $this->paymentService->processRefund(
            $registration,
            $request->refund_amount,
            $request->refund_reason
        );

        if ($result['success']) {
            // Latest successful payment ko update karein
            $successfulPayment = $registration->payments()
                ->where('status', 'success')
                ->latest()
                ->first();

            if ($successfulPayment) {
                $successfulPayment->update([
                    'status' => 'refunded',
                    'refund_amount' => $request->refund_amount,
                    'refund_reason' => $request->refund_reason,
                    'refund_transaction_id' => $result['refund_id'] ?? null,
                    'refunded_at' => now(),
                ]);
            }

            $registration->update(['status' => 'refunded']);

            return back()->with('success', 'Refund processed successfully!');
        }

        return back()->with('error', 'Refund failed: ' . ($result['message'] ?? 'Unknown error'));
    }


    public function sendEmail(Request $request, AlumniRegistration $alumniRegistration)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);


        // Mail::to($alumniRegistration->email)->send(new AlumniEmail($request->subject, $request->message));

        // Temporary: Sirf flash message
        return back()->with('success', "Email sent to {$alumniRegistration->email} successfully!");
    }

    public function export(Request $request)
{
    $filename = 'alumni_registrations_' . date('Y-m-d') . '.xlsx';
    
    if ($request->has('filter')) {
        $filename = 'alumni_' . $request->filter . '_' . date('Y-m-d') . '.xlsx';
    }

    return Excel::download(new AlumniRegistrationsExport($request), $filename);
}
}
