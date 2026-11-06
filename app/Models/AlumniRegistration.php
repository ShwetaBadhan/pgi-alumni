<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AlumniRegistration extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumni_registrations';

    // ✅ Sirf Core Fields (Normalized)
    protected $fillable = [
        'email',
        'password',
        'registration_type_id',
        'status',
        'membership_id',
        'comment',
    ];

    protected $hidden = ['password', 'remember_token'];

    // ✅ Relationships
    public function profile()
    {
        return $this->hasOne(AlumniProfile::class);
    }

    public function documents()
    {
        return $this->hasOne(AlumniDocument::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'registration_id');
    }

    public function accompanyingPersons()
    {

        return $this->hasMany(AccompanyingPerson::class, 'registration_id');
    }
    public function registrationType()
    {
        return $this->belongsTo(RegistrationType::class);
    }

    // Auto-generate Membership ID
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($registration) {
            if (!$registration->membership_id) {
                $lastRegistration = self::whereNotNull('membership_id')->orderBy('id', 'desc')->first();
                if ($lastRegistration && preg_match('/PGAAS(\d+)/', $lastRegistration->membership_id, $matches)) {
                    $nextNumber = (int)$matches[1] + 1;
                } else {
                    $nextNumber = 001;
                }
                $registration->membership_id = 'PGAAS' . $nextNumber;
            }
        });
    }

    // Accessors for easy use in Blade
    public function getFullNameAttribute()
    {
        return trim(($this->profile->title ?? '') . ' ' . ($this->profile->firstname ?? '') . ' ' . ($this->profile->lastname ?? ''));
    }
}
