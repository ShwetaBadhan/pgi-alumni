<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'registration_types';

    protected $fillable = [
        'name',
        'amount',
        'status',
    ];

    /**
     * Casts: Automatically formats the amount to 2 decimal places
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Constants for Status (Best practice to avoid magic strings)
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    // --- SCOPES (For easy querying) ---

    /**
     * Scope to get only active registration types
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to get only inactive registration types
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }
}