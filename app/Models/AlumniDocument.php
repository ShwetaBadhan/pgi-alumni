<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniDocument extends Model
{
    protected $fillable = [
        'alumni_registration_id',
        'profile_photo',
        'documentary_proof',
        'agreed_to_rules',
    ];

    protected $casts = [
        'agreed_to_rules' => 'boolean',
    ];

    public function alumni()
    {
        return $this->belongsTo(AlumniRegistration::class);
    }
}