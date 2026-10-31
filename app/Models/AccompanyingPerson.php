<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccompanyingPerson extends Model
{
    use HasFactory;

    protected $table = 'accompanying_persons';

    protected $fillable = [
        'registration_id',
        'name',
        'relation',
        'is_alumni',
        'alumni_membership_id',
        'wants_membership',
        'charge',
    ];

    protected $casts = [
        'is_alumni' => 'boolean',
        'wants_membership' => 'boolean',
        'charge' => 'decimal:2',
    ];

    // Relationship (Wapis Alumni Registration ki taraf)
    public function registration(): BelongsTo
    {
        return $this->belongsTo(AlumniRegistration::class, 'registration_id');
    }
}