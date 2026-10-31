<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbstractLog extends Model
{
    protected $fillable = [
        'submission_id', 'actor_type', 'actor_id', 'actor_name', 'action', 'remarks'
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(AbstractSubmission::class, 'submission_id');
    }
}