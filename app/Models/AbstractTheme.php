<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AbstractTheme extends Model
{
    protected $fillable = ['name', 'status'];

    public function submissions(): HasMany
    {
        return $this->hasMany(AbstractSubmission::class);
    }

    public function reviewerAssignments(): HasMany
    {
        return $this->hasMany(AbstractReviewerAssignment::class);
    }
}