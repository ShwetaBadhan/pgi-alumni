<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, BelongsToMany};
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class AbstractSubmission extends Model
{
    use SoftDeletes;
   protected $fillable = [
    'user_id',
    'title',
    'abstract_text',
    'keywords',
    'category_id',
    'theme_id',
    'status',
    'authors',               
    'co_author',             
    'primary_author_affiliation', 
];

    protected $casts = [
        'organizer_decided_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'student_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AbstractCategory::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(AbstractTheme::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id', '_id');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id', '_id');
    }

    // public function files(): HasMany
    // {
    //     return $this->hasMany(AbstractFile::class);
    // }

    // public function logs(): HasMany
    // {
    //     return $this->hasMany(AbstractLog::class);
    // }

    public function getStatusLabelAttribute(): array
    {
        $labels = [
            'submitted' => ['label' => 'Submitted (Awaiting Review)', 'class' => 'bg-info'],
            'resubmitted' => ['label' => 'Resubmitted (Awaiting Review)', 'class' => 'bg-info'],
            'reviewer_accepted' => ['label' => 'Reviewer Accepted', 'class' => 'bg-primary'],
            'reviewer_rejected' => ['label' => 'Reviewer Rejected', 'class' => 'bg-danger'],
            'sent_back' => ['label' => 'Sent Back for Revision', 'class' => 'bg-warning text-dark'],
            'organizer_accepted' => ['label' => 'Accepted', 'class' => 'bg-success'],
            'organizer_rejected' => ['label' => 'Rejected', 'class' => 'bg-danger'],
            'sent_to_reviewer' => ['label' => 'Sent to Reviewer', 'class' => 'bg-secondary'],
        ];

        return $labels[$this->status] ?? ['label' => ucfirst(str_replace('_', ' ', $this->status)), 'class' => 'bg-secondary'];
    }

    public function canBeDecidedByOrganizer(): bool
    {
        return $this->status === 'reviewer_accepted';
    }
     public function alumniUser(): BelongsTo
    {
        return $this->belongsTo(\App\Models\AlumniRegistration::class, 'user_id', 'membership_id');
    }

}