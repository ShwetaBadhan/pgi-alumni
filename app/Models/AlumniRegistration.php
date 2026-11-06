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

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->membership_id)) {
                // ✅ FIX: Soft deleted records ko ignore karein (whereNull('deleted_at'))
                $lastRegistration = static::whereNull('deleted_at')->orderBy('id', 'desc')->first();
                
                if ($lastRegistration && preg_match('/PGAAS(\d+)/', $lastRegistration->membership_id, $matches)) {
                    $nextNumber = (int)$matches[1] + 1;
                } else {
                    $nextNumber = 1;
                }
                
                // ✅ FIX: Unique check me bhi soft deleted ko ignore karein
                $newId = 'PGAAS' . $nextNumber;
                while (static::whereNull('deleted_at')->where('membership_id', $newId)->exists()) {
                    $nextNumber++;
                    $newId = 'PGAAS' . $nextNumber;
                }
                
                $model->membership_id = $newId;
            }
        });
    }


    // Accessors for easy use in Blade
    public function getFullNameAttribute()
    {
        return trim(($this->profile->title ?? '') . ' ' . ($this->profile->firstname ?? '') . ' ' . ($this->profile->lastname ?? ''));
    }
}
