<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'registration_id',     
        'registration_type_id',
        'amount',
        'type', 
        'currency',
        'gateway',
        'utr_number',
        'screenshot_path',
        'status',
        'response_payload',
    ];

    public function alumni()
    {
        
        return $this->belongsTo(AlumniRegistration::class, 'registration_id');
    }
       
    public function alumniRegistration()
    {
        
        return $this->belongsTo(AlumniRegistration::class, 'registration_id'); 
    }
}