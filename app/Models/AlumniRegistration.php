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
            // Agar membership_id pehle se set nahi hai, toh naya generate karo
            if (empty($model->membership_id)) {
                // Last registered user ko dhundho
                $lastRegistration = static::orderBy('id', 'desc')->first();
                
                if ($lastRegistration && preg_match('/PGAAS(\d+)/', $lastRegistration->membership_id, $matches)) {
                    // Agar last ID 'PGAAS3' thi, toh next 'PGAAS4' banegi
                    $nextNumber = (int)$matches[1] + 1;
                } else {
                    // Agar koi purana record nahi hai ya format match nahi hua, toh 1 se shuru karo
                    $nextNumber = 1;
                }
                
                // Unique check (Safety net: agar beech me koi delete hua ho)
                $newId = 'PGAAS' . $nextNumber;
                while (static::where('membership_id', $newId)->exists()) {
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
