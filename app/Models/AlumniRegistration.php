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
        'email',
        'password',
        'registration_type_id',
        'status',
        'membership_id',
        'comment',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
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

                // Get maximum membership number from ALL records,
                // including soft deleted records.

                $lastNumber = static::withTrashed()
                    ->where('membership_id', 'LIKE', 'PGAAS%')
                    ->selectRaw(
                        "MAX(CAST(SUBSTRING(membership_id, 6) AS UNSIGNED)) as max_number"
                    )
                    ->value('max_number');

                $nextNumber = ((int) $lastNumber) + 1;

                $model->membership_id = 'PGAAS' . $nextNumber;
            }
        });
    }

    // Accessor
    public function getFullNameAttribute()
    {
        return trim(
            ($this->profile->title ?? '') . ' ' .
            ($this->profile->firstname ?? '') . ' ' .
            ($this->profile->lastname ?? '')
        );
    }
}
