<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniProfile extends Model
{
    protected $fillable = [
        'alumni_registration_id',
        'title', 'firstname', 'middlename', 'lastname',
        'date_of_birth', 'contact_number', 'whatsapp_number',
        'degree_completed', 'current_position', 'department',
        'year_of_passing', 'year_of_joining_faculty', 'residence_country',
    ];

    public function alumni()
    {
        return $this->belongsTo(AlumniRegistration::class);
    }
}