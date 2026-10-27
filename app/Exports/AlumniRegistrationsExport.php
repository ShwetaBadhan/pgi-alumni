<?php

namespace App\Exports;

use App\Models\AlumniRegistration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class AlumniRegistrationsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    // Request ko constructor me receive karein taaki filter aur search kaam kare
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

   public function query()
{
    $query = AlumniRegistration::with('registrationType');
    $filter = $this->request->input('filter');
    $search = $this->request->input('search');
    $status = $this->request->input('status'); // ✅ New Status Filter

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
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('firstname', 'like', "%{$search}%")
              ->orWhere('lastname', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('contact_number', 'like', "%{$search}%");
        });
    }

    return $query->latest();
}

    // Excel ke columns ke headings
    public function headings(): array
    {
        return [
            'ID', 
            'Membership ID', 
            'Full Name', 
            'Email', 
            'Contact Number', 
            'Country',
            'Registration Type', 
            'Amount Paid', 
            'Accompanying Charge', 
            'Total Amount',
            'Transaction ID', 
            'Status', 
            'Registered Date'
        ];
    }

    // Data ko format karke Excel me bhejna
    public function map($reg): array
    {
        return [
            $reg->id,
            $reg->membership_id ?? 'N/A',
            $reg->full_name,
            $reg->email,
            $reg->contact_number,
            $reg->residence_country,
            $reg->registrationType->name ?? 'N/A',
            $reg->amount_paid,
            $reg->accompanying_charge ?? 0,
            $reg->total_amount,
            $reg->payment_transaction_id ?? 'N/A',
            ucfirst(str_replace('_', ' ', $reg->status)),
            $reg->created_at->format('d M Y'),
        ];
    }
}