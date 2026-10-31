<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Agar aapki table ka naam 'payments' hai

    protected $fillable = [
        'registration_id',
        'amount',
        'currency',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'status',
        'response_payload',
        'refund_amount',
        'refund_reason',
        'refund_transaction_id',
        'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'response_payload' => 'array',
        'refunded_at' => 'datetime',
    ];

    // Relationship with AlumniRegistration
    public function registration(): BelongsTo
    {
        return $this->belongsTo(AlumniRegistration::class, 'registration_id');
    }
}