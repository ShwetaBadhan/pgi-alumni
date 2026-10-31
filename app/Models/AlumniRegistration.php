<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AlumniRegistration extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumni_registrations';

    protected $fillable = [
        'title',
        'firstname',
        'middlename',
        'lastname',
        'date_of_birth',
        'contact_number',
        'whatsapp_number',
        'degree_completed',
        'department',
        'year_of_passing',
        'email',
        'password',
        'residence_country',
        'registration_type_id',
        'amount_paid',
        'payment_transaction_date',
        'payment_transaction_id',
        'has_accompanying_person',
        'accompanying_name',
        'accompanying_relation',
        'accompanying_is_alumni',
        'accompanying_alumni_id',
        'accompanying_charge',
        'comment',
        'agreed_to_rules',
        'status',
        'membership_id',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'payment_transaction_date' => 'date',
        'agreed_to_rules' => 'boolean',
        'has_accompanying_person' => 'boolean',
        'accompanying_is_alumni' => 'boolean',
        'amount_paid' => 'decimal:2',
        'accompanying_charge' => 'decimal:2',
    ];

    // Relationship with Registration Type
    public function registrationType()
    {
        return $this->belongsTo(RegistrationType::class, 'registration_type_id');
    }

    // Get Full Name
    public function getFullNameAttribute()
    {
        return trim("{$this->title} {$this->firstname} {$this->middlename} {$this->lastname}");
    }

    // Get Total Amount
    public function getTotalAmountAttribute()
    {
        return $this->amount_paid + $this->accompanying_charge;
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'registration_id');
    }

    // Get latest successful payment
    public function successfulPayment()
    {
        return $this->hasOne(Payment::class, 'registration_id')
            ->where('status', 'success')
            ->latestOfMany();
    }

    // Check if payment is successful
    public function isPaymentSuccessful()
    {
        return $this->payments()->where('status', 'success')->exists();
    }

    // Check if can be refunded
    public function canBeRefunded()
    {
        return in_array($this->status, ['approved', 'payment_pending']) && $this->amount_paid > 0;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($registration) {
            if (!$registration->membership_id) {

                $lastRegistration = self::whereNotNull('membership_id')
                    ->orderBy('id', 'desc')
                    ->first();


                if ($lastRegistration && preg_match('/PCAAS(\d+)/', $lastRegistration->membership_id, $matches)) {
                    $nextNumber = (int)$matches[1] + 1;
                } else {

                    $nextNumber = 1300;
                }


                $registration->membership_id = 'PCAAS' . $nextNumber;
            }
        });
    }
    public function accompanyingPersons()
    {
        return $this->hasMany(AccompanyingPerson::class, 'registration_id');
    }
}
