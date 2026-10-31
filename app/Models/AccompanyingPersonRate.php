<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccompanyingPersonRate extends Model
{
    use HasFactory;
    
    protected $table = 'accompanying_person_rates';
    
    protected $fillable = [
        'base_rate', 
        'is_discount_enabled', 
        'discount_percentage', // Yahan change kiya
        'status'
    ];
    
    protected $casts = [
        'is_discount_enabled' => 'boolean',
        'status' => 'boolean',
    ];
}