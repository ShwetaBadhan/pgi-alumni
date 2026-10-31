<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbstractReviewerAssignment extends Model
{
    protected $fillable = ['reviewer_id', 'category_id', 'theme_id', 'status'];

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewer_id', '_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AbstractCategory::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(AbstractTheme::class);
    }
}